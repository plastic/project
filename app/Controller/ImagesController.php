<?php 

class ImagesController extends AppController
{
	public function admin_add() {
		if ($this->request->is('post') && !empty($this->request->data)) {
			if ($this->Image->save($this->request->data)) {
				$name = $this->Image->read();
				$file['name'] = $name['Image']['basename'];
				$file['size'] = $this->request->data['Image']['file']['size'];
				$file['url'] = '/media/transfer/img/' . $name['Image']['basename'];
				$file['thumbnail_url'] = '/media/filter/thumbnail/img/' . $name['Image']['basename'];
				//$this->setFlashMessage('Usuário criado com sucesso!', 'success', array('action' => 'index'));
			} else {
				$file = 'Error';
			}
			$this->RequestHandler->renderAs($this, 'ajax');
			$this->set('file', '['.json_encode($file).']');
			$this->render('/elements/admin/ajax');
		}
		$this->set('user', AuthComponent::user() );
	}
	
	public function admin_del($id=null) {
		if ($this->request->is('get') || $this->request->is('delete')) {
			if ($this->Image->delete($id)) {
				$this->setFlashMessage('Imagem excluída com sucesso!', 'success', array('action' => 'index'));
			}
		}
	}
}
