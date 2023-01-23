<?php

namespace Tests\Feature\Api\StaticPage;

use App\Models\StaticPage\StaticPage;
use Tests\ApiTestCase;

class StaticPageTest extends ApiTestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStaticPageFindBySlug()
    {
        $staticPage1 = StaticPage::factory()->create();
        $staticPage2 = StaticPage::factory()->create();
        $staticPage3 = StaticPage::factory()->create();

        $this->get('/pages/'.$staticPage3->slug)
            ->assertStatus(200)
            ->assertJsonPath('result.id', $staticPage3->id);

        $this->get('/pages/'.$staticPage2->slug)
            ->assertStatus(200)
            ->assertJsonPath('result.id', $staticPage2->id);

    }

    public function testStaticPagePagination()
    {
        $staticPage1 = StaticPage::factory()->create();
        $staticPage2 = StaticPage::factory()->create();
        $staticPage3 = StaticPage::factory()->create();

        $this->get('/pages?perPage=1&sort=id&page=2')
            ->assertStatus(200)
            ->assertJsonPath('_meta.pagination.currentPage', 2)
            ->assertJsonPath('_meta.pagination.pageCount', 3)
            ->assertJsonPath('_meta.pagination.perPage', 1)
            ->assertJsonPath('_meta.pagination.totalCount', 3)
            ->assertJsonPath('result.0.id', $staticPage2->id);
    }
}
