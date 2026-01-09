<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title_id' => 'Tentang Kami',
                'title_en' => 'About Us',
                'slug' => 'about-us',
                'content_id' => '<h2>Selamat Datang di DMDI Magazine</h2>
                <p>DMDI Magazine adalah platform media digital yang berfokus pada pemberitaan dan analisis mendalam tentang dunia Melayu dan Islam di Indonesia.</p>
                
                <h3>Visi Kami</h3>
                <p>Menjadi media digital terdepan yang menyajikan informasi berkualitas, objektif, dan inspiratif tentang kehidupan Melayu-Islam di Indonesia dan kawasan Asia Tenggara.</p>
                
                <h3>Misi Kami</h3>
                <ul>
                    <li>Menyajikan berita dan artikel berkualitas tinggi dengan perspektif yang seimbang</li>
                    <li>Mempromosikan nilai-nilai keberagaman, toleransi, dan harmoni</li>
                    <li>Memberikan platform bagi suara-suara progresif dalam komunitas Muslim Indonesia</li>
                    <li>Mendorong dialog konstruktif tentang isu-isu kontemporer</li>
                </ul>
                
                <h3>Tim Kami</h3>
                <p>DMDI Magazine didukung oleh tim jurnalis profesional, akademisi, dan praktisi yang berpengalaman di bidangnya masing-masing. Kami berkomitmen untuk menjaga standar jurnalisme yang tinggi dan etika media yang bertanggung jawab.</p>
                
                <h3>Hubungi Kami</h3>
                <p>Jika Anda memiliki pertanyaan, saran, atau ingin berkolaborasi dengan kami, jangan ragu untuk menghubungi tim redaksi kami. </p>',
                
                'content_en' => '<h2>Welcome to DMDI Magazine</h2>
                <p>DMDI Magazine is a digital media platform focused on in-depth news and analysis about the Malay world and Islam in Indonesia.</p>
                
                <h3>Our Vision</h3>
                <p>To become the leading digital media that presents quality, objective, and inspiring information about Malay-Islamic life in Indonesia and Southeast Asia.</p>
                
                <h3>Our Mission</h3>
                <ul>
                    <li>Present high-quality news and articles with balanced perspectives</li>
                    <li>Promote values of diversity, tolerance, and harmony</li>
                    <li>Provide a platform for progressive voices in the Indonesian Muslim community</li>
                    <li>Encourage constructive dialogue on contemporary issues</li>
                </ul>
                
                <h3>Our Team</h3>
                <p>DMDI Magazine is supported by a team of professional journalists, academics, and practitioners experienced in their respective fields. We are committed to maintaining high journalism standards and responsible media ethics.</p>
                
                <h3>Contact Us</h3>
                <p>If you have questions, suggestions, or want to collaborate with us, please don\'t hesitate to contact our editorial team.</p>',
                
                'meta_description_id' => 'Tentang DMDI Magazine - Media digital yang fokus pada dunia Melayu dan Islam Indonesia',
                'meta_description_en' => 'About DMDI Magazine - Digital media focused on Malay world and Islam in Indonesia',
                'is_active' => true,
            ],
            [
                'title_id' => 'Hubungi Kami',
                'title_en' => 'Contact Us',
                'slug' => 'contact-us',
                'content_id' => '<h2>Hubungi DMDI Magazine</h2>
                <p>Kami senang mendengar dari Anda!  Silakan hubungi kami melalui salah satu cara berikut: </p>
                
                <h3>Email</h3>
                <p>redaksi@dmdi-magazine.com</p>
                
                <h3>Media Sosial</h3>
                <p>Ikuti kami di platform media sosial untuk update terbaru:</p>
                <ul>
                    <li>Instagram: @dmdi_magazine</li>
                    <li>Twitter/X: @dmdi_magazine</li>
                    <li>Facebook: DMDI Magazine</li>
                </ul>
                
                <h3>Alamat Redaksi</h3>
                <p>Jakarta, Indonesia</p>',
                
                'content_en' => '<h2>Contact DMDI Magazine</h2>
                <p>We\'d love to hear from you! Please contact us through one of the following ways: </p>
                
                <h3>Email</h3>
                <p>editorial@dmdi-magazine.com</p>
                
                <h3>Social Media</h3>
                <p>Follow us on social media platforms for the latest updates:</p>
                <ul>
                    <li>Instagram: @dmdi_magazine</li>
                    <li>Twitter/X: @dmdi_magazine</li>
                    <li>Facebook: DMDI Magazine</li>
                </ul>
                
                <h3>Editorial Address</h3>
                <p>Jakarta, Indonesia</p>',
                
                'meta_description_id' => 'Hubungi redaksi DMDI Magazine untuk pertanyaan, saran, atau kolaborasi',
                'meta_description_en' => 'Contact DMDI Magazine editorial team for questions, suggestions, or collaboration',
                'is_active' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}