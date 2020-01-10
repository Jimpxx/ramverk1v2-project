<?php

namespace Jiad\Tags\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

use Jiad\Post\Post;


/**
 * Form to update an item.
 */
class UpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $tags = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
                "escape-values" => false
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $tags->tagId,
                ],

                "tag" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $tags->tag,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }


    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * 
     * @return Tags
     */
    public function getItemDetails($id) : object
    {
        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));
        $tags->find("tagId", $id);
        return $tags;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));
        $tags->find("tagId", $this->form->value("id"));
        $tags->tag = $this->form->value("tag");
        $tags->save();
        return true;
    }



    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("tags")->send();
    //     //$this->di->get("response")->redirect("tags/update/{$tags->id}");
    // }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
