<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::table('urls')->insert([
            [
                'name' => "https://test.ru",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        DB::table('url_checks')->insert([
            [
                'url_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status_code' => 200,
                'h1' => "Test H1",
                'title' => "Test title",
                'description' => "Test description"
            ]
        ]);
    }

    public function testStore(): void
    {
        $data = ['url_id' => "1", 'created_at' => Carbon::now()];
        $expected = [
            'url_id'   => 1,
            'status_code' => 200,
            'h1'          => 'Test H1',
            'title'    => 'Test title',
            'description' => 'Test description',
        ];

        $html = file_get_contents(__DIR__ . '/../fixtures/test.html');
        if ($html  === false) {
            throw new \Exception('Something wrong with fixtures file');
        }
        Http::fake(['https://test.ru' => Http::response($html)]);

        $response = $this->post(route('urls.checks.store', $data['url_id']));
        $response->assertRedirect(route('urls.show', 1));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('url_checks', $data);
    }
}
