<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            // Programming Languages
            'JavaScript', 'Python', 'Java', 'PHP', 'CSharp', 'CPlusPlus', 'Ruby', 'Go', 'Rust', 'Swift',
            'TypeScript', 'Kotlin', 'Scala', 'R', 'MATLAB', 'Perl', 'Haskell', 'Lua', 'Dart',
            
            // Web Frameworks
            'Laravel', 'React', 'Vue.js', 'Angular', 'Express.js', 'Django', 'Flask', 'Spring',
            'ASP.NET', 'Ruby on Rails', 'Next.js', 'Nuxt.js', 'Svelte', 'Ember.js', 'Meteor',
            
            // Mobile Frameworks
            'React Native', 'Flutter', 'Xamarin', 'Ionic', 'NativeScript', 'Cordova',
            
            // Database
            'MySQL', 'PostgreSQL', 'MongoDB', 'SQLite', 'Redis', 'Oracle', 'SQL Server',
            
            // DevOps & Tools
            'Docker', 'Kubernetes', 'Git', 'Jenkins', 'Ansible', 'Terraform', 'AWS', 'Azure',
            'Google Cloud', 'Linux', 'Nginx', 'Apache',
            
            // Frontend Tools
            'Bootstrap', 'Tailwind CSS', 'Sass', 'Less', 'Webpack', 'Babel', 'jQuery',
            
            // Testing
            'Jest', 'Mocha', 'PHPUnit', 'Selenium', 'Cypress', 'JUnit',
            
            // AI & Data Science
            'TensorFlow', 'PyTorch', 'Scikit-learn', 'Pandas', 'NumPy', 'OpenCV',
            
            // Game Development
            'Unity', 'Unreal Engine', 'Godot', 'Phaser',
            
            // Security
            'OAuth', 'JWT', 'SSL', 'Penetration Testing', 'Cryptography'
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
            ]);
        }
    }
}
