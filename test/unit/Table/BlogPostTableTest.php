<?php
namespace Test\sfYaBlogPlugin\Unit\Table;

require_once dirname(__FILE__).'/../../bootstrap/all.php';

use BlogPostTable;


/**
 * BlogPostTable
 */
class BlogPostTableTest extends \myUnitTestCase
{
    /**
     * Выполнить запрос и проверить найденные записи
     */
    private function assertFoundPosts(array $posts, array $foundNames, \Doctrine_Query $q)
    {
        $found = $q->execute();
        $this->assertEquals(count($foundNames), $found->count());
        foreach ($foundNames as $i => $name) {
            $this->assertModels($posts[$name], $found[$i], "[{$i}] {$name}");
        }
    }


    /**
     * Выбрать опубликованные посты
     */
    public function testQueryActive()
    {
        $posts = array(
            'p1' => $this->helper->makeBlogPost(),
            'p2' => $this->helper->makeBlogPost(),
            'p3' => $this->helper->makeBlogPost(),
            'p4' => $this->helper->makeBlogPost(array('is_published' => false)),
        );

        $this->assertFoundPosts($posts, array('p1', 'p2', 'p3'), BlogPostTable::getInstance()->queryActive());
    }

}
