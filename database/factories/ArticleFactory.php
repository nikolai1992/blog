<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->sentence;
        $slug = Str::slug($name, '-');
        $images = array (
            "/dist/img/blog.jpg",
            "/dist/img/photo2.png",
            "/dist/img/photo4.jpg",
            "/dist/img/photo1.png"
        );

        $paragraphs = $this->faker->paragraphs(rand(2, 6));
        $post = "";
        foreach ($paragraphs as $para) {
            $post .= "<p>{$para}</p>";
        }
        $article_name = $this->faker->name;

        return [
            //
            "name" => $article_name,
            "title" => $article_name,
            "slug" => $slug,
            "image" => $images[rand(0, 2)],
            "short_description" => $this->faker->text,
            "description" => $post,
            "date_in" => $this->faker->dateTimeBetween('-2 years', '+0 days'),
            "user_id" => rand(1, 3),
            "published" => rand(0, 1),
            "paid_content" => rand(0, 1),
        ];
    }
}
