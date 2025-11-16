<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Categories
        $categories = [
            [
                'name_id' => 'Politik',
                'name_en' => 'Politics', 
                'slug' => 'politik',
                'description_id' => 'Berita dan analisis politik terkini',
                'description_en' => 'Latest political news and analysis'
            ],
            [
                'name_id' => 'Budaya',
                'name_en' => 'Culture',
                'slug' => 'budaya', 
                'description_id' => 'Artikel tentang budaya dan seni',
                'description_en' => 'Articles about culture and arts'
            ],
            [
                'name_id' => 'Gaya Hidup',
                'name_en' => 'Lifestyle',
                'slug' => 'gaya-hidup',
                'description_id' => 'Tren gaya hidup dan kesehatan',
                'description_en' => 'Lifestyle trends and health'
            ],
            [
                'name_id' => 'Teknologi',
                'name_en' => 'Technology',
                'slug' => 'teknologi',
                'description_id' => 'Berita dan perkembangan teknologi',
                'description_en' => 'Technology news and developments'
            ],
            [
                'name_id' => 'Pendidikan',
                'name_en' => 'Education',
                'slug' => 'pendidikan',
                'description_id' => 'Artikel pendidikan dan pengembangan diri',
                'description_en' => 'Education and self-development articles'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Articles
        $articles = [
            [
                'slug' => 'keindahan-budaya-melayu-indonesia',
                'title_id' => 'Keindahan Budaya Melayu di Indonesia',
                'title_en' => 'The Beauty of Malay Culture in Indonesia',
                'excerpt_id' => 'Budaya Melayu memiliki kekayaan yang luar biasa dalam seni, bahasa, dan tradisi...',
                'excerpt_en' => 'Malay culture has incredible richness in art, language, and traditions...',
                'content_id' => "<p>Budaya Melayu di Indonesia merupakan warisan yang sangat berharga. Dari ujung Sumatera hingga Kalimantan, budaya Melayu menyebar dengan keunikan masing-masing daerah.</p><p>Bahasa Melayu menjadi lingua franca yang menyatukan berbagai suku bangsa. Selain itu, seni musik seperti gambus, zapin, dan hadrah menjadi ciri khas yang masih dilestarikan hingga kini.</p><p>Tradisi seperti pantun, syair, dan gurindam menunjukkan kedalaman sastra Melayu yang patut dibanggakan.</p>",
                'content_en' => "<p>Malay culture in Indonesia is a very valuable heritage. From the tip of Sumatra to Kalimantan, Malay culture spreads with the uniqueness of each region.</p><p>The Malay language became the lingua franca that united various ethnic groups. In addition, musical arts such as gambus, zapin, and hadrah are typical features that are still preserved today.</p><p>Traditions such as pantun, syair, and gurindam show the depth of Malay literature that should be proud of.</p>",
                'featured_image' => null,
                'category_id' => 2,
                'author' => 'Ahmad Rizki',
                'view_count' => 1250,
                'is_published' => true,
                'is_featured' => true,
                'qr_code_path' => null
            ],
            [
                'slug' => 'perkembangan-islam-di-nusantara',
                'title_id' => 'Perkembangan Islam di Nusantara',
                'title_en' => 'The Development of Islam in the Archipelago', 
                'excerpt_id' => 'Islam datang ke Nusantara melalui jalur perdagangan dan disebarkan dengan damai...',
                'excerpt_en' => 'Islam came to the Archipelago through trade routes and was spread peacefully...',
                'content_id' => "<p>Islam masuk ke Nusantara melalui para pedagang dari Arab, Persia, dan India. Proses islamisasi berlangsung secara damai dan bertahap.</p><p>Wali Songo berperan penting dalam menyebarkan Islam di Jawa dengan pendekatan kultural yang bijaksana. Mereka tidak menghapus tradisi lokal, melainkan mengislamkannya.</p><p>Hingga kini, Islam menjadi agama mayoritas di Indonesia dengan karakter yang khas dan moderat.</p>",
                'content_en' => "<p>Islam entered the Archipelago through traders from Arabia, Persia, and India. The Islamization process took place peacefully and gradually.</p><p>The Wali Songo played an important role in spreading Islam in Java with a wise cultural approach. They did not erase local traditions, but rather Islamicized them.</p><p>Until now, Islam has become the majority religion in Indonesia with unique and moderate characteristics.</p>",
                'featured_image' => null,
                'category_id' => 2,
                'author' => 'Siti Fatimah',
                'view_count' => 890,
                'is_published' => true,
                'is_featured' => true,
                'qr_code_path' => null
            ],
            [
                'slug' => 'pentingnya-pendidikan-islam-modern',
                'title_id' => 'Pentingnya Pendidikan Islam Modern',
                'title_en' => 'The Importance of Modern Islamic Education',
                'excerpt_id' => 'Pendidikan Islam modern harus mengintegrasikan nilai-nilai agama dengan ilmu pengetahuan...',
                'excerpt_en' => 'Modern Islamic education must integrate religious values with science...',
                'content_id' => "<p>Pendidikan Islam di era modern menghadapi tantangan yang kompleks. Di satu sisi, harus mempertahankan nilai-nilai agama, di sisi lain harus mengikuti perkembangan zaman.</p><p>Integrasi antara ilmu agama dan ilmu umum menjadi kunci keberhasilan pendidikan Islam modern. Pesantren dan madrasah kini mulai mengadopsi kurikulum yang seimbang.</p><p>Dengan pendekatan yang tepat, pendidikan Islam dapat melahirkan generasi yang religius namun tetap kompetitif di dunia global.</p>",
                'content_en' => "<p>Islamic education in the modern era faces complex challenges. On one hand, it must maintain religious values, on the other hand it must follow the times.</p><p>Integration between religious science and general science is the key to the success of modern Islamic education. Islamic boarding schools and madrasas are now starting to adopt balanced curricula.</p><p>With the right approach, Islamic education can produce a generation that is religious but still competitive in the global world.</p>",
                'featured_image' => null,
                'category_id' => 5,
                'author' => 'Dr. Muhammad Ali',
                'view_count' => 670,
                'is_published' => true,
                'is_featured' => true,
                'qr_code_path' => null
            ],
            [
                'slug' => 'teknologi-ai-mengubah-dunia',
                'title_id' => 'Bagaimana Teknologi AI Mengubah Dunia',
                'title_en' => 'How AI Technology is Changing the World',
                'excerpt_id' => 'Kecerdasan buatan (AI) telah mengubah cara kita hidup dan bekerja secara fundamental...',
                'excerpt_en' => 'Artificial intelligence (AI) has fundamentally changed the way we live and work...',
                'content_id' => "<p>Kecerdasan buatan atau AI telah menjadi teknologi yang paling disruptif di abad ke-21. Dari asisten virtual hingga kendaraan otonom, AI mengubah cara kita berinteraksi dengan teknologi.</p><p>Dalam bidang kesehatan, AI membantu diagnosis penyakit lebih akurat. Di sektor bisnis, AI meningkatkan efisiensi operasional dan pengambilan keputusan.</p><p>Meskipun membawa banyak manfaat, AI juga menimbulkan pertanyaan etis yang perlu dijawab oleh masyarakat global.</p>",
                'content_en' => "<p>Artificial intelligence or AI has become the most disruptive technology of the 21st century. From virtual assistants to autonomous vehicles, AI is changing the way we interact with technology.</p><p>In healthcare, AI helps diagnose diseases more accurately. In the business sector, AI improves operational efficiency and decision making.</p><p>Despite bringing many benefits, AI also raises ethical questions that need to be answered by the global community.</p>",
                'featured_image' => null,
                'category_id' => 4,
                'author' => 'Budi Santoso',
                'view_count' => 1450,
                'is_published' => true,
                'is_featured' => false,
                'qr_code_path' => null
            ],
            [
                'slug' => 'tips-hidup-sehat-di-era-modern',
                'title_id' => 'Tips Hidup Sehat di Era Modern',
                'title_en' => 'Tips for Healthy Living in the Modern Era',
                'excerpt_id' => 'Gaya hidup sehat bukan hanya tentang diet, tetapi tentang keseimbangan fisik dan mental...',
                'excerpt_en' => 'Healthy living is not just about diet, but about physical and mental balance...',
                'content_id' => "<p>Di tengah kesibukan era modern, menjaga kesehatan seringkali terabaikan. Namun, gaya hidup sehat adalah investasi jangka panjang yang sangat penting.</p><p>Mulai dari olahraga rutin, pola makan seimbang, hingga manajemen stres yang baik. Semua aspek ini saling terkait dalam menciptakan kualitas hidup yang lebih baik.</p><p>Tidur yang cukup dan menghindari kebiasaan buruk seperti merokok juga menjadi kunci utama hidup sehat.</p>",
                'content_en' => "<p>In the midst of the busyness of the modern era, maintaining health is often neglected. However, a healthy lifestyle is a very important long-term investment.</p><p>Starting from regular exercise, balanced diet, to good stress management. All these aspects are interrelated in creating a better quality of life.</p><p>Adequate sleep and avoiding bad habits like smoking are also key to healthy living.</p>",
                'featured_image' => null,
                'category_id' => 3,
                'author' => 'Dr. Rina Kusuma',
                'view_count' => 980,
                'is_published' => true,
                'is_featured' => false,
                'qr_code_path' => null
            ],
            [
                'slug' => 'politik-lokal-dan-partisipasi-masyarakat',
                'title_id' => 'Politik Lokal dan Partisipasi Masyarakat',
                'title_en' => 'Local Politics and Community Participation',
                'excerpt_id' => 'Partisipasi aktif masyarakat dalam politik lokal sangat penting untuk pembangunan daerah...',
                'excerpt_en' => 'Active community participation in local politics is crucial for regional development...',
                'content_id' => "<p>Politik lokal memainkan peran vital dalam pembangunan daerah. Partisipasi masyarakat tidak hanya saat pemilihan, tetapi juga dalam pengawasan kebijakan.</p><p>Dengan semakin terbukanya akses informasi, masyarakat kini lebih mudah untuk terlibat dalam proses politik lokal. Media sosial menjadi platform yang efektif untuk menyuarakan aspirasi.</p><p>Pemerintah daerah yang responsif terhadap kebutuhan warganya akan menciptakan pembangunan yang lebih inklusif dan berkelanjutan.</p>",
                'content_en' => "<p>Local politics plays a vital role in regional development. Community participation is not only during elections, but also in policy oversight.</p><p>With increasingly open access to information, people now find it easier to be involved in local political processes. Social media has become an effective platform for voicing aspirations.</p><p>Local governments that are responsive to the needs of their citizens will create more inclusive and sustainable development.</p>",
                'featured_image' => null,
                'category_id' => 1,
                'author' => 'Hendra Wijaya',
                'view_count' => 756,
                'is_published' => true,
                'is_featured' => false,
                'qr_code_path' => null
            ],
            [
                'slug' => 'seni-tradisional-di-era-digital',
                'title_id' => 'Melestarikan Seni Tradisional di Era Digital',
                'title_en' => 'Preserving Traditional Arts in the Digital Era',
                'excerpt_id' => 'Era digital membuka peluang baru untuk melestarikan dan mempromosikan seni tradisional...',
                'excerpt_en' => 'The digital era opens new opportunities to preserve and promote traditional arts...',
                'content_id' => "<p>Seni tradisional Indonesia memiliki kekayaan yang luar biasa, dari tari, musik, hingga kerajinan tangan. Di era digital, seni tradisional menghadapi tantangan sekaligus peluang.</p><p>Platform digital memungkinkan seniman tradisional menjangkau audiens global. Video streaming dan media sosial menjadi medium baru untuk pertunjukan dan pembelajaran seni.</p><p>Kolaborasi antara seniman tradisional dan teknologi digital menciptakan bentuk ekspresi baru yang tetap menghargai nilai-nilai budaya.</p>",
                'content_en' => "<p>Indonesian traditional arts have extraordinary wealth, from dance, music, to handicrafts. In the digital era, traditional arts face both challenges and opportunities.</p><p>Digital platforms enable traditional artists to reach global audiences. Video streaming and social media have become new mediums for performances and art learning.</p><p>Collaboration between traditional artists and digital technology creates new forms of expression while respecting cultural values.</p>",
                'featured_image' => null,
                'category_id' => 2,
                'author' => 'Dewi Sartika',
                'view_count' => 623,
                'is_published' => true,
                'is_featured' => false,
                'qr_code_path' => null
            ],
            [
                'slug' => 'tren-fashion-sustainable',
                'title_id' => 'Tren Fashion Sustainable yang Ramah Lingkungan',
                'title_en' => 'Sustainable Fashion Trends that are Eco-Friendly',
                'excerpt_id' => 'Fashion sustainable bukan hanya tren, tetapi kebutuhan untuk menjaga planet kita...',
                'excerpt_en' => 'Sustainable fashion is not just a trend, but a necessity to protect our planet...',
                'content_id' => "<p>Industri fashion merupakan salah satu penyumbang polusi terbesar di dunia. Namun, tren fashion sustainable kini semakin populer sebagai solusi ramah lingkungan.</p><p>Dari penggunaan bahan organik hingga daur ulang pakaian bekas, berbagai inovasi dilakukan untuk mengurangi dampak lingkungan. Brand lokal maupun internasional berlomba menciptakan produk yang stylish namun eco-friendly.</p><p>Konsumen juga semakin sadar akan pentingnya memilih fashion yang sustainable. Slow fashion menjadi alternatif dari fast fashion yang merusak lingkungan.</p>",
                'content_en' => "<p>The fashion industry is one of the largest polluters in the world. However, sustainable fashion trends are now increasingly popular as eco-friendly solutions.</p><p>From using organic materials to recycling used clothes, various innovations are being made to reduce environmental impact. Local and international brands are competing to create products that are stylish yet eco-friendly.</p><p>Consumers are also increasingly aware of the importance of choosing sustainable fashion. Slow fashion has become an alternative to environmentally damaging fast fashion.</p>",
                'featured_image' => null,
                'category_id' => 3,
                'author' => 'Laila Nurjanah',
                'view_count' => 845,
                'is_published' => true,
                'is_featured' => false,
                'qr_code_path' => null
            ],
            [
                'slug' => 'metode-pembelajaran-interaktif',
                'title_id' => 'Metode Pembelajaran Interaktif untuk Generasi Z',
                'title_en' => 'Interactive Learning Methods for Generation Z',
                'excerpt_id' => 'Generasi Z membutuhkan metode pembelajaran yang lebih interaktif dan engaging...',
                'excerpt_en' => 'Generation Z needs more interactive and engaging learning methods...',
                'content_id' => "<p>Generasi Z tumbuh dengan teknologi di ujung jari mereka. Metode pembelajaran tradisional seringkali tidak efektif untuk generasi ini yang terbiasa dengan interaksi digital.</p><p>Gamifikasi, pembelajaran berbasis proyek, dan penggunaan teknologi AR/VR membuat proses belajar lebih menarik. Platform e-learning interaktif juga memberikan fleksibilitas bagi siswa untuk belajar sesuai pace mereka.</p><p>Guru dan pendidik perlu beradaptasi dengan karakteristik generasi Z untuk menciptakan lingkungan pembelajaran yang optimal.</p>",
                'content_en' => "<p>Generation Z grew up with technology at their fingertips. Traditional learning methods are often ineffective for this generation accustomed to digital interactions.</p><p>Gamification, project-based learning, and the use of AR/VR technology make the learning process more engaging. Interactive e-learning platforms also provide flexibility for students to learn at their own pace.</p><p>Teachers and educators need to adapt to the characteristics of Generation Z to create an optimal learning environment.</p>",
                'featured_image' => null,
                'category_id' => 5,
                'author' => 'Prof. Andi Pratama',
                'view_count' => 712,
                'is_published' => true,
                'is_featured' => false,
                'qr_code_path' => null
            ]
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
}