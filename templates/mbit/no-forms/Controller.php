<?php
/*********************************************************************************************
*  Mbit Studio j.d.o.o 
*  Dragutina Golika 63 
*  10000, Zagreb Croatia
*  Email: contact [@] mbit.io
*  Author: Jerko Puratic - jerko.puratic@mbit.io
*  Web: http://www.mbit.io
*
*  Controller $className$ autogenerated by phalcon-devtools(Mbit version) with (CRUD) actions
*
*********************************************************************************************/

$namespace$
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


use Faker\Factory as FakerFactory;
use App\$className$\Models\$className$Model;
use App\$className$\Transformers\$className$Transformer;
use App\$className$\Processors\$className$Processor;
use App\Core\Controllers\BaseController;

use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;


class $className$Controller extends BaseController
{

    /**
     * Read action
	 *
     * Lists a $className$ items (cRud)
     *
	 * If get '/module/controller/read' is requested by action 'read' without parameters we list all records,
	 * If get '/module/controller/read/1' is requested by action 'read' with parameter '1' we list record that have id/primary key = 1
	 *
     * @internal param int $id
     */



    public function readAction($pkVar$ = null)
    {
        $this->persistent->parameters = null;

		$id = (int) $pkVar$;

        if(!empty($id)) {

            $singularVar$ = $className$::find($id);

            return $this->api->withCollection($singularVar$, new $className$Transformer())->send();



        }

            $singularVar$ = $className$::find();

            return $this->api->withCollection($singularVar$, new $className$Transformer())->send();

    }


	/**
     * Search action
	 *
     * Searchs a $className$ items for $plural$
     *
     * @internal param int $id
     */

    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "$className$", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "$pk$";

        $pluralVar$ = $className$::find($parameters);
        if (count($pluralVar$) == 0) {
            $this->flash->notice("The search did not find any $plural$");

            return $this->dispatcher->forward(array(
                "controller" => "$plural$",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $pluralVar$,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }


	/**
     * Update action 
	 *
     * Updates $singular$ item with JSON POST data (crUd)
	 *
	 * If POST '/module/controller/update/1' is requested by action 'update' with parameter '1' we 
	 * populate/update record with received JSON data that have id/primary key = 1 
	 * 
     *
     * @param int $pkVar$
     */

    public function updateAction($pkVar$)
    {

		if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "$plural$",
                "action" => "index"
            ));
        }

		$singularVar$ = $this->request->getJsonRawBody();

		$new_$singularVar$ = new $className$Model::findFirst($pkVar$);

        $assignInputFromRequestCreate$

        if (!$new_$singularVar$->save()) {
            

			$this->response->setJsonContent(array('status' => 'ERROR', 'messages' => 'Contact ID: '.$pkVar$.' updated.'));
            $this->response->send();

        }

         $this->response->setJsonContent(array('status' => 'SUCCESS', 'messages' => 'Contact ID: '.$pkVar$.' updated.'));
         $this->response->send();


    }


	/**
     * Create action 
	 *
     * Creates new $singular$ item with JSON POST data (Crud)
	 *
	 * If POST '/module/controller/create' is requested by action 'create' we 
	 * create new record and populate it with received JSON data. 
	 * 
     *
     * @param int $pkVar$
     */


    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "$plural$",
                "action" => "index"
            ));
        }

		$singularVar$ = $this->request->getJsonRawBody();

		$new_$singularVar$ = new $className$Model();

        $assignInputFromRequestCreate$

        if (!$new_$singularVar$->save()) {
            

			$this->response->setJsonContent(array('status' => 'ERROR', 'messages' => 'New '.$singularVar$.' NOT saved.'));
            $this->response->send();

        }

         $this->response->setJsonContent(array('status' => 'SUCCESS', 'messages' => 'New '.$singularVar$.' saved.'));
         $this->response->send();

    }


	/**
	 * Deletes a new $singular$ action 
	 *
	 * Delete $singular$ item (cruD)
	 *
	 * If POST '/module/controller/delete/1' is requested by action 'delete' with parameter '1' we 
	 * delete record that have id/primary key = 1
	 *
	 * @param int $pkVar$
	 */


    public function deleteAction($pkVar$)
    {

		if($className$Model::findFirst($pkVar$)->delete()) {

            $this->response->setJsonContent(array('status' => 'SUCCESS', 'messages' => 'Contact ID: ' . $pkVar$ . ' deleted.'));
            $this->response->send();

        } else {

            $this->response->setJsonContent(array('status' => 'ERROR', 'messages' => 'Contact ID: '.$pkVar$.' NOT deleted.'));
            $this->response->send();

        }

    }

}