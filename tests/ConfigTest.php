<?php
namespace DenDev\Plpskeleton\Test;
use DenDev\Plpskeleton\Skeleton;


class SkeletonTest extends \PHPUnit_Framework_TestCase 
{
	public function test_instanciate()
	{
		$object = new Skeleton();
		$this->assertInstanceOf( "DenDev\Plpskeleton\Skeleton", $object );
	}
}
