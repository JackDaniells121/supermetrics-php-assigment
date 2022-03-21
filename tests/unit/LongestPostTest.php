<?php

declare(strict_types = 1);

namespace Tests\unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use SocialPost\Hydrator\FictionalPostHydrator;
use Statistics\Calculator\MaxPostLength;
use Statistics\Dto\ParamsTo;

/**
 * Class ATestTest
 *
 * @package Tests\unit
 */
class LongestPostTest extends TestCase
{
    /**
     * @test
     */
    public function testLongestPost(): void
    {

        $string = file_get_contents("tests/data/social-posts-response.json");
        $jsonArray = json_decode($string, true);

        $paramsTo = new ParamsTo();
        $paramsTo->setStartDate(new DateTime('2011-01-01'));
        $paramsTo->setStatName('Test');

        $calculator = new MaxPostLength();
        $calculator->setParameters($paramsTo);

        $postMaxLength = 0;

        foreach ($jsonArray['data']['posts'] as $post) {

            $hydrator = new FictionalPostHydrator();
            $socialPostTo = $hydrator->hydrate($post);
            $calculator->accumulateData($socialPostTo);

            $currentPostLength = strlen($post['message']);
            if ($currentPostLength >= $postMaxLength) {
                $postMaxLength = $currentPostLength;
            }
        }

        $this->assertEquals($postMaxLength, $calculator->calculate()->getValue());
    }
}
