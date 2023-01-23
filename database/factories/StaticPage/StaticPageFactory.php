<?php
namespace Database\Factories\StaticPage;

use App\Models\StaticPage\StaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class StaticPageFactory
 * @package Database\Factories\StaticPage
 */
class StaticPageFactory extends Factory
{
    protected $model = StaticPage::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'content' => $this->faker->sentence(10),
            'meta_title' => $this->faker->sentence(2),
            'meta_description' => $this->faker->sentence(10),
            'slug' => $this->faker->unique()->text(10),
            'sort_order' => $this->faker->randomNumber(),
            'created_at' => $this->faker->unixTime(),
            'updated_at' => $this->faker->unixTime(),
        ];
    }
}
