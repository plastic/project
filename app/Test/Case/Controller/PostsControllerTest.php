<?php

class PostsControllerTest extends ControllerTestCase
{
	public function testIndex()
	{
		$results = $this->testAction('posts/index/');
	}
	
	public function testAdd() {
		$data = array(
			'Post' => array(
				'title' => 'titulo',
				'content' => 'Lorem ipsum dolor sit amet, consectetur dipisicina'
			)
		);
		$results = $this->testAction('posts/add', array('data' => $data, 'method' => 'post'));
	}
	
	public function testEdit(){
		$results1 = $this->testAction('posts/edit/1');
		$data = array(
			'Post' => array(
				'id' => 1,
				'title' => 'teste update',
				'content' => 'teste de update do texto'
			)
		);  
		$results2 = $this->testAction('posts/edit', array('data' => $data, 'method' => 'post'));
	}
	
	public function testDelete(){
		$results = $this->testAction('posts/delete/1');
	}
}
