<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
// use  App\Form\UserForm;
class Controller extends AbstractController {
  private $router;
    public function __construct( RouterInterface $router){
  $this->router = $router;

      }
  // private $formfactory;
  // public function __construct (FormBuilderInterface $FormFactory){
  //   $this->FormFactory = $formfactory;
  // }
/**
*@Route("/1",name="1home")
*/
public function i1ndex(){

$posts= [
[
  'id' => 1,
  'title' =>  'post1',
  'body' => 'hhhhhhhhhh'
],
[
  'id' => 2,
  'title' =>  'post2',
  'body' => 'hhhhhhhhhh'
],
[
  'id' => 3,
  'title' =>  'post3',
  'body' => 'hhhhhhhhhh'
]

];
  //die("Connection failed: " ." mysqli_connect_error()");

return $this->render('index.html.twig',[
   'posts'=>$posts ]) ;


}


/**
*@Route("/add",name="post_add")
*/
public function add(Request $request){
// $form=$this->FormFactory->create(UserForm::class);

return  $this->render('add.html.twig',['form'=>$form->createsView() ]);

}
/**
*@Route("/showall",name="showall")
*/
public function showall(){
$repository=$this->getDoctrine()->getRepository(User::class);
$user= $repository->findAll();
return  $this->render('test.html.twig',['users'=>users]);

}
/**
*@Route("/test",name="post_test")
*/
public function test(){
  return new Response(
    'test post'
  );
  // $users;
  // return $this->render('test.html.twig',[
  //    'users'=>$users ]) ;
}

}

?>
