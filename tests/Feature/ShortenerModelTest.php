use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShortenerModelTest extends TestCase
{
    use DatabaseTransactions; // Rollback database transactions after each test

    public function testCreateShortenerModel()
    {
        $data = [
            'url' => 'https://example.com',
            'title' => 'Example Title',
        ];

        $shortenerModel = ShortenerModel::create($data);

        $this->assertInstanceOf(ShortenerModel::class, $shortenerModel);
        $this->assertEquals($data['url'], $shortenerModel->url);
        $this->assertEquals($data['title'], $shortenerModel->title);
    }
}
