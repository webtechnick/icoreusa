<?php
App::uses('AppController', 'Controller');
/**
 * Uploads Controller
 *
 * @property Upload $Upload
 */
class UploadsController extends AppController {

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if ($this->Upload->restrictedDelete($id, $this->Auth->user('id'))) {
			$this->goodFlash(__('Image deleted'));
		} else {
			$this->badFlash('Unable to delete image');
		}
		$this->redirect(array('controller' => 'contractors', 'action' => 'edit'));
	}
}
