<#
Quick, safe PowerShell script to rename resources/views/Admin -> resources/views/admin
and fix references "Admin." -> "admin." in *.php and *.blade.php files.
Run this from repo root in PowerShell.

It will:
 - ensure git repo and optionally require clean working tree (asks user)
 - create branch fix/views-admin-case
 - preview matches for "Admin."
 - ask for confirmation before applying changes
 - rename folder using a temp name so Git records case-only rename
 - replace occurrences in php/blade files
 - commit & push branch
 - run artisan cache clears and storage:link if php is available
#>

function Write-Info($m){ Write-Host "[INFO] $m" -ForegroundColor Cyan }
function Write-Warn($m){ Write-Host "[WARN] $m" -ForegroundColor Yellow }
function Write-Err($m){ Write-Host "[ERROR] $m" -ForegroundColor Red }

# Ensure in git repo
if (-not (Test-Path ".git")) {
    Write-Err "No .git folder found in current directory. Please run this script from the repository root."
    exit 1
}

# Ensure git is available
if (-not (Get-Command git -ErrorAction SilentlyContinue)) {
    Write-Err "git executable not found in PATH."
    exit 1
}

# Check working tree status
$porcelain = git status --porcelain
if ($porcelain) {
    Write-Warn "You have uncommitted changes:"
    Write-Host $porcelain
    $resp = Read-Host "Continue anyway? (y/N)"
    if ($resp.ToLower() -ne 'y') {
        Write-Info "Aborting. Please commit or stash changes and re-run the script."
        exit 0
    }
}

# Create branch
$branch = "fix/views-admin-case"
Write-Info "Creating and switching to branch $branch"
git checkout -b $branch

# Preview occurrences of Admin.
Write-Info "Previewing occurrences of 'Admin.' in *.php and *.blade.php..."
$matches = Get-ChildItem -Path . -Include *.php,*.blade.php -Recurse -File -ErrorAction SilentlyContinue `
    | Select-String -Pattern '\bAdmin\.' -SimpleMatch:$false

if (-not $matches) {
    Write-Warn "No occurrences of 'Admin.' found in *.php or *.blade.php files."
} else {
    Write-Info "Found the following matches:"
    $matches | ForEach-Object {
        Write-Host "$($_.Path):$($_.LineNumber) -> $($_.Line)"
    }
}

$confirm = Read-Host "Proceed to perform rename + replacements? (y/N)"
if ($confirm.ToLower() -ne 'y') {
    Write-Info "Aborting as requested. No changes made."
    exit 0
}

# Rename folder resources/views/Admin -> resources/views/admin using temp name
$oldFolder = Join-Path -Path "resources" -ChildPath "views\Admin"
$tempFolder = Join-Path -Path "resources" -ChildPath "views\Admin_temp_for_case_change"
$newFolder = Join-Path -Path "resources" -ChildPath "views\admin"

if (Test-Path $oldFolder) {
    Write-Info "Renaming folder resources/views/Admin -> resources/views/admin (via temp name)."
    git mv "resources/views/Admin" "resources/views/Admin_temp_for_case_change"
    git mv "resources/views/Admin_temp_for_case_change" "resources/views/admin"
} else {
    Write-Warn "Folder resources/views/Admin not found. Skipping folder rename step."
}

# Replace references only in php/blade files
Write-Info "Replacing occurrences of '\bAdmin\.' -> 'admin.' in *.php and *.blade.php files..."
$files = Get-ChildItem -Path . -Include *.php,*.blade.php -Recurse -File -ErrorAction SilentlyContinue
$updatedCount = 0
foreach ($f in $files) {
    try {
        $path = $f.FullName
        $text = Get-Content -Raw -Encoding UTF8 -Path $path
        $new = [System.Text.RegularExpressions.Regex]::Replace($text, '\bAdmin\.', 'admin.')
        if ($new -ne $text) {
            Set-Content -Encoding UTF8 -Path $path -Value $new
            Write-Host "Updated: $path"
            $updatedCount++
        }
    } catch {
        Write-Warn "Failed to process $path : $_"
    }
}
Write-Info "Replacement complete. Files updated: $updatedCount"

# Stage and commit changes if any
$changes = git status --porcelain
if ($changes) {
    Write-Info "Staging changes..."
    git add -A
    git commit -m "Fix view references: Admin.* -> admin.* and rename views/Admin to views/admin (case fix)"
    Write-Info "Pushing branch to origin..."
    git push -u origin HEAD
} else {
    Write-Warn "No changes to commit."
}

# Run artisan maintenance commands if php is available
if (Get-Command php -ErrorAction SilentlyContinue) {
    Write-Info "Running artisan cache clear & storage:link (requires laravel project)."
    php artisan view:clear
    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear
    # storage:link may fail if already linked or not allowed; ignore non-zero exit
    php artisan storage:link 2>$null
    Write-Info "Artisan commands executed (errors suppressed where safe)."
} else {
    Write-Warn "php not found in PATH. Skipping artisan commands. Run them manually if needed."
}

Write-Info "Script finished. Please verify changes locally and run your app to ensure everything works."