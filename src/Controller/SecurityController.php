<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Feeling;
use App\Entity\Transaction;
use App\Entity\CreditorLoan;
use App\Entity\User;
use App\Entity\Loan;
use App\Entity\Msg;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityController extends AbstractController {
  public $dir='_edit Loan';
  public $dirid=1;
  private $passwordEncoder;
private $router;
private $session;


  public function __construct(UserPasswordEncoderInterface $passwordEncoder
, RouterInterface $router,SessionInterface $session){
$this->router = $router;
      $this->passwordEncoder = $passwordEncoder;
      $this->session = $session;
    }

/**
*@Route("/user/login",name="security_login")
*/
public function login(Request $request){
  $user = new User();
  $form = $this->createFormBuilder($user)
                ->add('user_name', TextType::class)
                ->add('password', PasswordType::class)
               ->add('Login', SubmitType::class)
               ->getForm();

    $form->handleRequest($request);
               if($form->isSubmitted() && $form->isValid() ){
 return new Response('sorry ,   ' );
               $repository = $this->getDoctrine()->getRepository(User::class);
          $check_user = $repository->findOneBy(['user_name' => $user->getUserName() ,'password' => $user->getPassword() ]);

     if($check_user)    return new Response('sorry ,   ' );

     // put it in sesion
      return new RedirectResponse( $this->router->generate('home') );
}
 return $this->render('security/login.html.twig',['form' => $form->createView() ]
);
}


/**
*@Route("/user/login-page",name="login-page")
*/
public function loginPage()
{
  return $this->render('security/login-page.html.twig');
}

/**
*@Route("/login-submit",name="login-submit")
*/
public function loginSubmit(Request $request)
{
  $credntials = [
    'username' => $request->request->get('username'),
    'password' => $request->request->get('password')
  ];


  $repository = $this->getDoctrine()->getRepository(User::class);
//   $user= $repository->findOneBy(['user_name' => $user->getUserName()]);
//$check_user = $this->passwordEncoder->isPasswordValid($user, $user->getPassword() );
//   $check_user = $repository->findOneBy(['user_name' => $user->getUserName() ,'password' => $this->passwordEncoder->encodePassword($user,  $user->getPassword() ) ]);
$check_user = $repository->findOneBy(['user_name' =>$credntials["username"] ,'password' =>    $credntials["password"]]);
$cookie_value =  $repository->findOneBy(['user_name' =>$credntials["username"] ,'password' =>    $credntials["password"]]);
//   $cookie_name = "cur_user";

if(!$check_user)    return new Response('sorry ,   ' );
//session_start();

$this->session->set('cur_user', $cookie_value);
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
// setcookie('cur_user', $check_user , time() + (86400 * 30), "/" );
// put it in sesion
return new RedirectResponse( $this->router->generate('home') );

  return new JsonResponse($credntials);

}

/**
*@Route("/login",name="login")
*/
public function _login(Request $request){
  $user = new User();
  $form = $this->createFormBuilder($user)
                ->add('user_name', TextType::class)
                ->add('password', PasswordType::class)
               ->add('Login', SubmitType::class)
               ->getForm();

    $form->handleRequest($request);
               if($form->isSubmitted() && $form->isValid() ){

         $repository = $this->getDoctrine()->getRepository(User::class);
      //   $user= $repository->findOneBy(['user_name' => $user->getUserName()]);
 //$check_user = $this->passwordEncoder->isPasswordValid($user, $user->getPassword() );
      //   $check_user = $repository->findOneBy(['user_name' => $user->getUserName() ,'password' => $this->passwordEncoder->encodePassword($user,  $user->getPassword() ) ]);
      $check_user = $repository->findOneBy(['user_name' => $user->getUserName() ,'password' =>    $user->getPassword()]);
  $cookie_value =  $repository->findOneBy(['user_name' => $user->getUserName() ,'password' =>    $user->getPassword()]);
 //   $cookie_name = "cur_user";

     if(!$check_user)    return new Response('sorry ,   ' );


   $this->session->set('cur_user', $cookie_value);
     // setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
// setcookie('cur_user', $check_user , time() + (86400 * 30), "/" );
     // put it in sesion
      return new RedirectResponse( $this->router->generate('home') );
}
 return $this->render('security/login.html.twig',['form' => $form->createView() ]
);
}

////

/**
*@Route("/user/Register-page",name="Register-page")
*/
public function _RegisterPage()
{
  return $this->render('security/Register-page.html.twig');
}

/**
*@Route("/Register-submit",name="Register-submit")
*/
public function _RegisterSubmit(Request $request)
{


  $data = [
    'username' => $request->request->get('username'),
    'password' => $request->request->get('password'),
    'mail' => $request->request->get('mail'),
    'address' => $request->request->get('address'),
    'name' => $request->request->get('name'),
    'WhatsApp' => $request->request->get('WhatsApp'),
    'isCreditor' => ($request->request->get('isCreditor'))?1:0,
    'isDebtor' => ($request->request->get('isDebtor'))?1:0,
    'isGuarantor' => ($request->request->get('isGuarantor'))?1:0
  ];
     $entityManager = $this->getDoctrine()->getManager();
$user=new User();
$user->setUserName($data['username']);
  $repository = $this->getDoctrine()->getRepository(User::class);
  $check_user = $repository->findOneBy(['user_name' => $user->getUserName() ]);

if($check_user)    return new Response('sorry ,  your user_name is repeated   ' );

//     $errors = $validator->validate($user);
// if (count($errors) > 0) {
//     return new Response((string) $errors, 400);
// }

$user->setname($data['name']);
$user->setaddress($data['address']);
$user->setmail($data['mail']);

$user->setWhatsApp($data['WhatsApp']);
$user->setPassword($data['password']);
$user->setIsCreditor($data['isCreditor']);
$user->setIsDebtor($data['isDebtor']);
$user->setIsGuarantor($data['isGuarantor']);
$user->setIsAdmin(0);

//  $user->setPassword($this->passwordEncoder->encodePassword($user,  $user->getPassword() ));
// tell Doctrine you want to (eventually) save the Product (no queries yet)

$entityManager->persist($user);

// actually executes the queries (i.e. the INSERT query)
$entityManager->flush();
return new RedirectResponse( $this->router->generate('login-page') );
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
// setcookie('cur_user', $check_user , time() + (86400 * 30), "/" );
// put it in sesion
// return new RedirectResponse( $this->router->generate('home') );


}

////

/*
public function checkCredentials($credentials, UserInterface $user)
{
    return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
}
*/
/**
 * @Route("/FormRegister", name="register")
 */
 public function FormRegister(Request $request)
 {

   // // you can fetch the EntityManager via $this->getDoctrine()
   //       // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
   $entityManager = $this->getDoctrine()->getManager();
   //
         $user = new User();
         $form = $this->createFormBuilder($user)
                       ->add('user_name', TextType::class)
                       ->add('password', PasswordType::class)
                       ->add('mail', EmailType::class)
                       ->add('address', TextType::class)
                      ->add('name', TextType::class)
                      ->add('isCreditor', CheckboxType::class, [

    'required' => false,
])
                    ->add('isDebtor', CheckboxType::class,[

  'required' => false,
])
                      ->add('isGuarantor', CheckboxType::class,[

    'required' => false,
])
                      ->add('save', SubmitType::class)
                      ->getForm();
          //  $form= $this->createForm();
            $form->handleRequest($request);


            if($form->isSubmitted() && $form->isValid() ){

            $repository = $this->getDoctrine()->getRepository(User::class);
       $check_user = $repository->findOneBy(['user_name' => $user->getUserName() ]);

  if($check_user)    return new Response('sorry ,  your user_name is repeated   ' );

       //     $errors = $validator->validate($user);
       // if (count($errors) > 0) {
       //     return new Response((string) $errors, 400);
       // }

 $user->setIsAdmin(0);

    //  $user->setPassword($this->passwordEncoder->encodePassword($user,  $user->getPassword() ));
      // tell Doctrine you want to (eventually) save the Product (no queries yet)

       $entityManager->persist($user);

       // actually executes the queries (i.e. the INSERT query)
       $entityManager->flush();
return new RedirectResponse( $this->router->generate('login-page') );
  }


  return $this->render('security/Registerpage.html.twig',['form' => $form->createView() ]);





   // $repository = $this->getDoctrine()->getRepository(User::class);
   //
   // $users = $repository->findAll();
   // return $this->render('all.html.twig',[
   //    'users'=>$users ]) ;

 }

// loan part

/**
 * @Route("/Loan/1reguestLoan", name="1reguest Loan")
 */
public function reguestLoan(Request $request )
{
$loan = new Loan();

 // // you can fetch the EntityManager via $this->getDoctrine()
 //       // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
 $entityManager = $this->getDoctrine()->getManager();
 $user = new User();
//  $form1 = $this->createFormBuilder($user)
//  ->add('user_name', TextType::class)
//  ->add('password', PasswordType::class)
// ->add('save', SubmitType::class)
//               ->getForm();
if(! $this->session->get('cur_user')) {

return new RedirectResponse( $this->router->generate('login-page') );
}
       $form = $this->createFormBuilder($loan)
                       ->add('money', TextType::class)
                    ->add('save', SubmitType::class)
                    ->getForm();
        //  $form= $this->createForm();
          $form->handleRequest($request);


          if($form->isSubmitted() && $form->isValid()    ){

// return new Response($user->getUserName() );
//     $repository = $this->getDoctrine()->getRepository(User::class);
//     $user = $repository->findOneBy(['user_name' => $user->getUserName() ]);

$loan->setState(0);
$loan->setDebtor( $this->session->get('cur_user')->getId());
// $loan->setDebtor( $_COOKIE["cur_user"]->getId());

     $entityManager->persist($loan);

     // actually executes the queries (i.e. the INSERT query)
     $entityManager->flush();
return new RedirectResponse( $this->router->generate('home') );
}


return $this->render('security/Register.html.twig',['form' => $form->createView()  ]);


}




// /**
// *@Route("/logout",name="security_logout")
// */
// public function logout(AuthenticationUtils $authentication){
// return $this->render('security/login.html.twig',[
//   'last_username' => $authentication->getLastUsername();,
//   'error' => $authentication->getLastAuthentificationError();
// ]
// );
// }


/**
 * @Route("/createAdmin", name="createAdmin")
 */
public function createAdmin()
{


 // // you can fetch the EntityManager via $this->getDoctrine()
 //       // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
 $entityManager = $this->getDoctrine()->getManager();
 //
       $user = new User();
       $user->setname('hassan');
       $user->setaddress('0000');
       $user->setmail('asa20000928@gmail.com');
       $user->setUserName('hassanAdmin');
$user->setIsAdmin(1);
    // $user->setPassword($this->passwordEncoder->encodePassword($user,  '0000' ));
$user->setPassword('0000');
$user->setIsGuarantor(0);
$user->setIsDebtor(0);
$user->setIsCreditor(0);
$user->setMoney(0);
$user->setWhatsApp(0);
   // // tell Doctrine you want to (eventually) save the Product (no queries yet)
   $entityManager->persist($user);

   // actually executes the queries (i.e. the INSERT query)
   $entityManager->flush();

   return new Response('create Admin',200);


}
/**
 * @Route("/Msg/To/action/watch0/{id}", name="watch0 action")
 */
 public function ActionWatch0(User $user)
 {



       $repository = $this->getDoctrine()->getRepository(Msg::class);
         $msgW0T0 = $repository->findBy(['userTo' => $user->getId(), 'watch' =>0 , 'typeMsg'=>1]);
          $msgW1T1Rn = $repository->findBy(['userTo' => $user->getId(), 'watch' =>1 , 'typeMsg'=>1,'result'=>null]);
            $msgW1T1R1 = $repository->findBy(['userTo' => $user->getId(), 'watch' =>1 , 'typeMsg'=>1,'result'=>1 ]);
              $msgW1T1R0 = $repository->findBy(['userTo' => $user->getId(), 'watch' =>1 , 'typeMsg'=>1,'result'=>0 ]);
$datamsgW0T0=[];
foreach ($msgW0T0 as $key ) {
 array_push($datamsgW0T0 , ['id'=> $key->getId() , 'LoanId' => $key->getLoanId(),  'text' => $key->getText() ,'result'=>null  ]  );
}

$datamsgW1T1Rn=[];
foreach ($msgW1T1Rn as $key ) {
 array_push($datamsgW1T1Rn , ['id'=> $key->getId() , 'LoanId' => $key->getLoanId(),  'text' => $key->getText(),'result'=>null  ]  );
}

$datamsgW1T1R1=[];
foreach ($msgW1T1R1 as $key ) {
 array_push($datamsgW1T1R1 , ['id'=> $key->getId() , 'LoanId' => $key->getLoanId(),  'text' => $key->getText(),'result'=>1  ]  );
}
$datamsgW1T1R0=[];
foreach ($msgW1T1R0 as $key ) {
 array_push($datamsgW1T1R0 , ['id'=> $key->getId() , 'LoanId' => $key->getLoanId(),  'text' => $key->getText(),'result'=>0  ]  );
}
return $this->render('Msg/ActionMsg.html.twig',
['datamsgW0T0' => $datamsgW0T0
,'datamsgW1T1Rn' => $datamsgW1T1Rn
,'datamsgW1T1R1' => $datamsgW1T1R1
,'datamsgW1T1R0' => $datamsgW1T1R0  ]);
 }



// function CheckinputError($input){
//   $user;
//   $repository = $this->getDoctrine()->getRepository(User::class);
//
//   if(is_numeric($input)){
//    $user = $repository->findOneBy(['id' => $input ]);
//    if(! $user) return 1;
//   }
//   else{
//     $user = $repository->findOneBy(['user_name' => $input ]);
//    if(! $user) return  1;
//
//   }
//   return 0;
// }
function CheckinputError($input){
$user=null;
  $repository = $this->getDoctrine()->getRepository(User::class);

  if(is_numeric($input)){
   $user = $repository->findOneBy(['id' => $input ]);

  }
  else{
    $user = $repository->findOneBy(['user_name' => $input ]);


  }
  return $user;
}
 /**
  * @Route("/Loan/reguestLoan1", name="reguest Loan1")
  */
 public function reguestLoan1(Request $request )
 {

 if(! $this->session->get('cur_user')) {
        return new RedirectResponse( $this->router->generate('login-page') );
 }

  $entityManager = $this->getDoctrine()->getManager();
  $loan = new Loan();
        $form = $this->createFormBuilder($loan)
        ->add('First_Guarantor', TextType::class)
        ->add('Second_Guarantor', TextType::class)
        ->add('money', TextType::class)
        ->add('save', SubmitType::class)
        ->getForm();
         //  $form= $this->createForm();

 //         $userF;
 //         $userS;
 //
 //           $repository = $this->getDoctrine()->getRepository(User::class);
 //
 //           if(is_numeric($loan->getFirstGuarantor())){
 //            $userF = $repository->findOneBy(['id' => $loan->getFirstGuarantor() ]);
 //        //    if(! $user)  return new Response('Error in First Guarantor  ') ;
 //           }
 //           else{
 //             $userF = $repository->findOneBy(['user_name' => $loan->getFirstGuarantor() ]);
 //        //    if(! $user) return new Response('Error in First Guarantor  ') ;
 //
 //           }
 //
 //           if(is_numeric($loan->getSecondGuarantor())){
 //            $userS = $repository->find(['id' => $loan->getSecondGuarantor() ]);
 //           if(! $user)  return new Response('Error in Second Guarantor  ');
 //           }
 //           else{
 //             $userS = $repository->findOneBy(['user_name' => $loan->getSecondGuarantor() ]);
 //           if(! $userS)  return new Response('Error in Second Guarantor  '.$loan->getSecondGuarantor().'2');
 //
 //           }
 //           $loan->setFirstGuarantor($userF->getId());
 //           $loan->setSecondGuarantor($userS->getId());
 //
 //        //
  $form->handleRequest($request);
           if($form->isSubmitted()  && $form->isValid()   ){





// if(CheckinputError($loan->getFirstGuarantor())) return new Response('Error in First Guarantor  ') ;
// if(CheckinputError($loan->getSecondGuarantor())) return new Response('Error in Second Guarantor  ') ;


 $loan->setState(0);
 $loan->setDebtor( $this->session->get('cur_user')->getId());
      $entityManager->persist($loan);
      $entityManager->flush();
 return new RedirectResponse( $this->router->generate('home') );


 }


 return $this->render('security/Register.html.twig',['form' => $form->createView()  ]);


 }


 /**
 *@Route("/",name="home")
 */
 public function index(){
   session_start();
$user= $this->session->get('cur_user');
 $noUser;
 $name='';
 $id=0;
 $isAdmin=0;
 if($user){
    $noUser=0;
      $name=$user->getname();
  $id=$user->getId();
  if($user->getIsAdmin())$isAdmin=1;
 }
 else{
    $noUser=1;
 }

 return $this->render('home-page.html.twig',['noUser'=>$noUser
 // ,'name'=>($this->session->get('cur_user'))?$this->session->get('cur_user')->getname():'sss'
 ,'name'=>$name, 'id'=> $id , 'isAdmin'=>$isAdmin
  ]) ;


 }
 /**
 *@Route("/logout",name="logout")
 */
 public function logout(){
    $this->session->set('cur_user', 0);
     return new RedirectResponse( $this->router->generate('home') );
 }

 /**
  * @Route("/Loan/reguestLoan", name="_reguest Loan1")
  */
 public function _reguestLoan()
 {
   if(! $this->session->get('cur_user')) {

   return new RedirectResponse( $this->router->generate('login-page') );
   }

   return $this->render('input-page-defult.html.twig',
   [
'cardTitle'=>'reguest Loan'
,'Title' => 'reguest Loan'
    , 'action_path'=> 'reguestLoan1-submit','idsubmit'=>0
, 'inputs'=>[['name'=>'First_Guarantor'],['name'=>'Second_Guarantor'],['name'=>'money']],'btn'=>'reqest'
 ]);
 }


 /**
 *@Route("/reguestLoan1-submit/{id}",name="reguestLoan1-submit")
 */
 public function  _reguestLoanSubmit(Request $request)
 {
   if(! $this->session->get('cur_user')) {

   return new RedirectResponse( $this->router->generate('login-page') );
   }

    $First_Guarantor = $request->request->get('First_Guarantor');
    $Second_Guarantor = $request->request->get('Second_Guarantor');
    $money = $request->request->get('money');



       $entityManager = $this->getDoctrine()->getManager();
$loan =new Loan();
$First_Guarantor=$this->CheckinputError($First_Guarantor);
    if(! $First_Guarantor ) return new Response('error in First_Guarantor') ;
$loan->setFirstGuarantor($First_Guarantor->getId());
$Second_Guarantor=$this->CheckinputError($Second_Guarantor);
    if(! $Second_Guarantor ) return new Response('error in Guarantor') ;
$loan->setSecondGuarantor($Second_Guarantor->getId());
$loan->setMoney($money);
 $loan->setDebtor( $this->session->get('cur_user')->getId());
$loan->setState(0);
  $entityManager->persist($loan);
     $entityManager->flush();
   return new RedirectResponse( $this->router->generate('home') );

 }

 /**
 *@Route("/user/_editAccount-page/{id}",name="_editAccount-page")
 */
 public function _editAccountPage(User $user)
 {
   if(! $this->session->get('cur_user')) {

   return new RedirectResponse( $this->router->generate('login-page') );
   }

      if(! $this->session->get('cur_user')->getIsAdmin())  return new Response('you must be admin !');
     if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );

   $loan=$this->session->get('Loan_edit');
    // if(! $this->session->get('cur_user')->getIsAdmin())  return new
   //  if (! $this->session->get('Loan_edit')) return new
  $transactionData=$this->TransactionData(['User'=>$user->getId(),'Loan'=>$loan->getId()]);

   return $this->render('user/editAccount-page.html.twig',
   [
    'transactionData'=>$transactionData
    ,'loanData'=>['id'=> $loan->getId()   ]
,'cardTitle'=>'Edit Account'
,'Title' => 'Edit Account'
    , 'action_path'=> '_editAccount-submit','idsubmit'=>$user->getId()
, 'inputs'=>[['name'=>'Account']],'btn'=>'Edit'
 ]);
 }


 /**
 *@Route("/_editAccount-submit/{id}",name="_editAccount-submit")
 */
 public function  _editAccountSubmit(User $user,Request $request)
 {
     if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
// loan //user //send //receive //Type
     $account = $request->request->get('Account');
     if(!is_numeric($account)) return new Response('account must be number');
     $type = $request->request->get('Type');
$this->dirid=$this->session->get('Loan_edit')->getId();

    $transaction= new Transaction(new \DateTime(),$this->session->get('Loan_edit')->getId() ,$user->getId() );
    if($type=='send'){
      $transaction->setSend($account);
    }else if ($type=='receive'){
        $transaction->setReceive($account);
    }
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($transaction);
    $entityManager->flush();

return new RedirectResponse( $this->router->generate($this->dir,['id'=>$this->dirid]) );

 }

 /**
  * @Route("/Loan/1state0", name="1state0 Loan")
  */
  public function _1state0()
  {
 //$this->dir='1state0 Loan';
    $repository = $this->getDoctrine()->getRepository(Loan::class);
 //return new Response(    $this->dir );
  //
 $Loans = $repository->findBy(['state' => 0]);
 $data =[] ;

  // $Loans = $repository-> getRepository('AppBundle:User')->findAll();
 foreach ($Loans as $key ) {
  $userSecond_Guarantor=null ;
  $userFirst_Guarantor=null ;
  $userDebtor=null ;
  $userCreditor=null ;
  $repository = $this->getDoctrine()->getRepository(User::class);
  $repositoryCL = $this->getDoctrine()->getRepository(CreditorLoan::class);
 if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
 if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
 if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);


  $Creditors=$repositoryCL->findby(['loan' => $key->getId() ]);
  $dataCreditor = [];
  foreach ($Creditors as $keyCL ) {

    $userCreditor = $repository->find(['id' => $keyCL->getUser() ]);
       array_push($dataCreditor , [ 'userId' => ($userCreditor) ? $userCreditor->getId() : 0
       , 'name' => ($userCreditor) ? $userCreditor->getname(): ' ' , 'id'=> $keyCL->getId() ]   );
  }


 array_push($data,['Creditor' => $dataCreditor
 ,'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
 , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
 , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
 ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
 ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate()->format('Y-m-d \ h:i:s') : ' '
 ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate()->format('Y-m-d \ h:i:s') : ' '
 , 'id'=>  $key->getId()      ] );
 }
 return $this->render('Loan/1state0.html.twig',[
     'data'=>$data ]) ;




  }


     /**
     *@Route("/loan/addCreditor-page/{id}",name="addCreditor-page")
     */
     public function addCreditorPage(Loan $loan)
     {
       return $this->render('/input-page-defult.html.twig',
       [
 'cardTitle'=>'Add Creditor'
 ,'Title' => 'Add Creditor'
        , 'action_path'=> 'addCroditor-submit','idsubmit'=>$loan->getId()
 , 'inputs'=>[['name'=>'Creditor']],'btn'=>'Add'
     ]);
       return $this->render('Loan/addCroditor-page.html.twig',['id'=>$loan->getId() ]);
     }



     /**
     *@Route("/addCroditor-submit/{id}",name="addCroditor-submit")
     */
     public function addCroditorSubmit(Loan $loan,Request $request)
     {
            if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
$this->dirid=$this->session->get('Loan_edit')->getId();
         $Creditor = $request->request->get('Creditor');



  $creditorloan= new CreditorLoan();


           $entityManager = $this->getDoctrine()->getManager();

       $creditorloan->setLoan($loan->getId());
  $user=$this->CheckinputError($Creditor);
      if(! $user ) return new Response('error') ;
         $creditorloan->setUser($user->getId());
   $entityManager->persist($creditorloan);

         $entityManager->flush();
      return new RedirectResponse( $this->router->generate($this->dir,['id'=>$this->dirid]) );

     }

     /**
      * @Route("/Loan/1all", name="1home Loan")
      */
      public function _1allLoan()
      {
     //   return new Response( $this->dir);
  //$this->dir='1home Loa';
        $repository = $this->getDoctrine()->getRepository(Loan::class);
       $data =[] ;
       $Loans = $repository->findAll();
         // $Loans = $repository-> getRepository('AppBundle:User')->findAll();
       foreach ($Loans as $key ) {
         $userSecond_Guarantor=null ;
         $userFirst_Guarantor=null ;
         $userDebtor=null ;
         $userCreditor=null ;
         $repository = $this->getDoctrine()->getRepository(User::class);
         $repositoryCL = $this->getDoctrine()->getRepository(CreditorLoan::class);
         if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
         if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
         if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);


         $Creditors=$repositoryCL->findby(['loan' => $key->getId() ]);
          $dataCreditor=[];
          foreach ($Creditors as $keyCL ) {

            $userCreditor = $repository->find(['id' => $keyCL->getUser() ]);
               array_push($dataCreditor, [ 'userId' => ($userCreditor) ? $userCreditor->getId() : 0
               , 'name' => ($userCreditor) ? $userCreditor->getname(): ' ' , 'id'=> $keyCL->getId() ]   );
          }

$sta="";
if($key->getState()==0)$sta="prepare";
else if($key->getState()==1)$sta="Accept";
else if($key->getState()==-1)$sta="Reject";
         array_push($data,['Creditor' => $dataCreditor
         ,'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
         , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
         , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
         ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
         ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate()->format('Y-m-d \ h:i:s') : ' '
         ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate()->format('Y-m-d \ h:i:s')  : ' '
         , 'id'=>  $key->getId()
         , 'state'=> $sta   ] );
       }
       return $this->render('Loan/1all.html.twig',[
            'data'=>$data ]) ;

      }

            /**
             * @Route("/Loan/CreditorLoan/del/{id}", name="del CreditorLoan")
             */
            public function delCreditorLoan(CreditorLoan $loan )
            {
                   if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
              $this->dirid=$this->session->get('Loan_edit')->getId();
                $entityManager = $this->getDoctrine()->getManager();
         $entityManager->remove($loan);
         $entityManager->flush();
        return new RedirectResponse( $this->router->generate($this->dir,['id'=>$this->dirid]) );


            }

            /**
            *@Route("/laon/_editEndDate-page/{id}",name="_editEndDate-page")
            */
            public function _editEndDatePage(Loan $loan)
            {
              return $this->render('/input-page-defult.html.twig',
              [
 'cardTitle'=>'Edit EndDate'
 ,'Title' => 'Edit EndDate'
               , 'action_path'=> '_editEndDate-submit','idsubmit'=>$loan->getId()
  , 'inputs'=>[['name'=>'EndDate']],'btn'=>'Edit'
            ]);
            }
            /**
            *@Route("/laon/_editStartDate-page/{id}",name="_editStartDate-page")
            */
            public function _editStartDatePage(Loan $loan)
            {
              return $this->render('/input-page-defult.html.twig',
              [
          'cardTitle'=>'Edit StartDate'
          ,'Title' => 'Edit StartDate'
               , 'action_path'=> '_editStartDate-submit','idsubmit'=>$loan->getId()
          , 'inputs'=>[['name'=>'StartDate']],'btn'=>'Edit'
            ]);
            }


            /**
            *@Route("/_editStartDate-submit/{id}",name="_editStartDate-submit")
            */
            public function  _editStartDateSubmit(Loan $loan,Request $request)
            {
     if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
                $StartDate = $request->request->get('StartDate');

          $this->dirid=$this->session->get('Loan_edit')->getId();

                  $entityManager = $this->getDoctrine()->getManager();

            $loan->setStartDate(new \DateTime($StartDate));

                $entityManager->flush();
            return new RedirectResponse( $this->router->generate($this->dir,['id'=>$this->dirid]) );

            }

            /**
            *@Route("/_editEndDate-submit/{id}",name="_editEndDate-submit")
            */
            public function  _editEndDateSubmit(Loan $loan,Request $request)
            {
     if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
                $EndDate = $request->request->get('EndDate');

$this->dirid=$this->session->get('Loan_edit')->getId();

                  $entityManager = $this->getDoctrine()->getManager();

            $loan->setEndDate(new \DateTime($EndDate));

                $entityManager->flush();
            return new RedirectResponse( $this->router->generate($this->dir,['id'=>$this->dirid]) );

            }

            /**
            *@Route("/_editMoney-submit/{id}",name="_editMoney-submit")
            */
            public function  _editMoneySubmit(Loan $loan,Request $request)
            {
     if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
                $Money = $request->request->get('Money');
if(! is_numeric($Money))  return new Response('error');
$this->dirid=$this->session->get('Loan_edit')->getId();

                  $entityManager = $this->getDoctrine()->getManager();

            $loan->setMoney($Money);

                $entityManager->flush();
            return new RedirectResponse( $this->router->generate($this->dir,['id'=>$this->dirid]) );

            }
            /**
            *@Route("/laon/_editMoney-page/{id}",name="_editMoney-page")
            */
            public function _editMoneyPage(Loan $loan)
            {
              return $this->render('/input-page-defult.html.twig',
              [
 'cardTitle'=>'Edit Money'
,'Title' => 'Edit Money'
               , 'action_path'=> '_editMoney-submit','idsubmit'=>$loan->getId()
  , 'inputs'=>[['name'=>'Money']],'btn'=>'Edit'
            ]);
            }

            /**
            *@Route("/laon/_editFirst_Guarantor-page/{id}",name="_editFirst_Guarantor-page")
            */
            public function _editFirst_GuarantorPage(Loan $loan)
            {
              return $this->render('/input-page-defult.html.twig',
              [
 'cardTitle'=>'Edit First_Guarantor'
 ,'Title' => 'Edit First_Guarantor'
               , 'action_path'=> '_editFirst_Guarantor-submit','idsubmit'=>$loan->getId()
  , 'inputs'=>[['name'=>'First_Guarantor']],'btn'=>'Edit'
            ]);
            }


            /**
            *@Route("/_editFirst_Guarantor-submit/{id}",name="_editFirst_Guarantor-submit")
            */
            public function  _editFirst_GuarantorSubmit(Loan $loan,Request $request)
            {
     if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
                $First_Guarantor = $request->request->get('First_Guarantor');

$this->dirid=$this->session->get('Loan_edit')->getId();

                  $entityManager = $this->getDoctrine()->getManager();

                  $First_Guarantor=$this->CheckinputError($First_Guarantor);
                      if(! $First_Guarantor ) return new Response('error in First_Guarantor') ;
                  $loan->setFirstGuarantor($First_Guarantor->getId());

                $entityManager->flush();
          return new RedirectResponse( $this->router->generate($this->dir,['id'=>$this->dirid]) );

            }
            /**
            *@Route("/laon/_editSecond_Guarantorpage/{id}",name="_editSecond_Guarantor-page")
            */
            public function _editSecond_GuarantorPage(Loan $loan)
            {
       //       return new Response(    $this->dir );
              return $this->render('/input-page-defult.html.twig',
              [
         'cardTitle'=>'Edit Second_Guarantor'
         ,'Title' => 'Edit Second_Guarantor'
               , 'action_path'=> '_editSecond_Guarantor-submit','idsubmit'=>$loan->getId()
         , 'inputs'=>[['name'=>'Second_Guarantor']],'btn'=>'Edit'
            ]);
            }

            /**
            *@Route("/laon/_editSecond_Guarantor-page/{id}",name="_editSecond_Guarantor-submit")
            */

            public function  _editSecond_GuarantorSubmit(Loan $loan,Request $request)
            {
     if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
                $Second_Guarantor = $request->request->get('Second_Guarantor');

$this->dirid=$this->session->get('Loan_edit')->getId();

                  $entityManager = $this->getDoctrine()->getManager();

                  $Second_Guarantor=$this->CheckinputError($Second_Guarantor);
                      if(! $Second_Guarantor ) return new Response('error in Guarantor') ;
                  $loan->setSecondGuarantor($Second_Guarantor->getId());

                $entityManager->flush();
          return new RedirectResponse( $this->router->generate($this->dir,['id'=>$this->dirid]) );

            }

            /**
             * @Route("/Loan/_edit/{id}", name="_edit Loan")
             */
             public function  _edit_loan(Loan $key)
             {
               //   return new Response( $this->dir);
            //$this->dir='1home Loa';
 $this->session->set('Loan_edit', $key);
                 $data =[] ;


                   $userSecond_Guarantor=null ;
                   $userFirst_Guarantor=null ;
                   $userDebtor=null ;
                   $userCreditor=null ;
                   $repository = $this->getDoctrine()->getRepository(User::class);
                   $repositoryCL = $this->getDoctrine()->getRepository(CreditorLoan::class);
                   if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
                   if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
                   if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);


                   $Creditors=$repositoryCL->findby(['loan' => $key->getId() ]);
                    $dataCreditor=[];
                    foreach ($Creditors as $keyCL ) {

                      $userCreditor = $repository->find(['id' => $keyCL->getUser() ]);
                         array_push($dataCreditor, [ 'userId' => ($userCreditor) ? $userCreditor->getId() : 0
                         , 'name' => ($userCreditor) ? $userCreditor->getname(): ' ' , 'id'=> $keyCL->getId() ]   );
                    }


                    $data=['Creditor' => $dataCreditor
                   ,'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
                   , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
                   , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
                   ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
                   ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate()->format('Y-m-d \ h:i:s') : ' '
                   ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate()->format('Y-m-d \ h:i:s')  : ' '
                   , 'id'=>  $key->getId()
                   ,'state'=>   $key->getState()   ]  ;

                   return $this->render('Loan/edit Loan.html.twig',[
                        'loan'=>$data ]
                         ) ;



             }
function TransactionData($condiction){
  $repository = $this->getDoctrine()->getRepository(Transaction::class);
  $transaction = $repository->findBy($condiction);
  $receiveMoney=0;
  $sendMoney=0;
  $cnt=0;
  $data=[];
  foreach ($transaction as $key ) {
  $sendMoney+=( $key->getSend())? $key->getSend() : 0 ;
 $receiveMoney+=($key->getReceive()) ? $key->getReceive() : 0 ;
 array_push($data, [ 'date' =>   $key->getDate()->format('Y-m-d ')
 , 'loan' => $key->getLoan() , 'user'=> $key->getUser() ,'id'=> $key->getId()
 , 'send' =>$key->getSend()  , 'receive' => $key->getReceive(),'cnt'=>++$cnt ]   );
  }
  return ['data'=>$data, 'sendMoney'=>$sendMoney, 'receiveMoney'=>$receiveMoney ];
}


function Feeling($condiction){
  $repository = $this->getDoctrine()->getRepository(Feeling::class);
  $feeling= $repository->findBy($condiction);
  $data=[];
  $sendMoney=0;
 $receiveMoney=0 ;
 $cnt=0;
  foreach ($feeling as $key ) {
    $sendMoney+=( $key->getIncrease())? $key->getIncrease() : 0 ;
   $receiveMoney+=($key->getDecrease()) ? $key->getDecrease() : 0 ;
  array_push($data, [ 'date' =>   $key->getDate()->format('Y-m-d ')
   , 'user'=> $key->getUser() ,'id'=> $key->getId()
  , 'increase' =>$key->getIncrease()  , 'decrease' => $key->getDecrease() ,'cnt'=>++$cnt ]   );
   }

   return ['data'=>$data, 'increase'=>$sendMoney, 'decrease'=>$receiveMoney];

}
/**
*@Route("/user/Report-page/{id}",name="Report-page")
*/
public function ReportPage(Loan $loan)
{
  if(! $this->session->get('cur_user')) {

  return new RedirectResponse( $this->router->generate('login-page') );
  }

   if(! $this->session->get('cur_user')->getIsAdmin())  return new Response('you must be admin !');
  if (! $this->session->get('Loan_edit'))   return new RedirectResponse( $this->router->generate('1home Loan') );
 $transactionData=$this->TransactionData(['Loan'=>$loan->getId()]);

  return $this->render('Loan/Report.html.twig',
  [
   'transactionData'=>$transactionData
   ,'loanData'=>['id'=> $loan->getId()   ]

,'Title' => 'Report '


]);
}

/**
*@Route("/user/addfeeling-page",name="addfeeling-page")
*/
public function addfeelingPage()
{
  if(! $this->session->get('cur_user')) {

  return new RedirectResponse( $this->router->generate('login-page') );
  }

$Debtor=$this->session->get('cur_user')->getIsDebtor();
$Creditor=$this->session->get('cur_user')->getIsCreditor();
  return $this->render('user/addfeeling.html.twig',
  [
'cardTitle'=>'Add feeding'
,'Title' => 'Add feeding'
   , 'action_path'=> 'addfeeling-submit','idsubmit'=>0
, 'inputs'=>[['name'=>'Feeding']],'btn'=>'Done','Debtor'=>$Debtor,'Creditor'=>1
]);
}


/**
*@Route("/addfeeling-submit/{id}",name="addfeeling-submit")
*/
public function  addfeelingSubmit(Request $request)
{
  if(! $this->session->get('cur_user')) {

  return new RedirectResponse( $this->router->generate('login-page') );
  }

    $account = $request->request->get('Feeling');
 $type=$request->request->get('Type');

$feeling= new Feeling(new \DateTime(),$this->session->get('cur_user')->getId() );
if($type=='Creditor'){
  $feeling->setIncrease($account);
}else if ($type=='Debtor'){
    $feeling->setDecrease($account);
}
      $entityManager = $this->getDoctrine()->getManager();

$entityManager->persist($feeling);

    $entityManager->flush();
return new RedirectResponse( $this->router->generate('home') );

}
/**
*@Route("/user/showActions",name="showActions")
*/
public function showActions()
{
  if(! $this->session->get('cur_user')) {

  return new RedirectResponse( $this->router->generate('login-page') );
  }

$id=  $this->session->get('cur_user')->getId();
 $feeling=$this->Feeling(['user'=>$id]);
 $transactionData=$this->TransactionData(['User'=>$id]);

  return $this->render('user/showActions.html.twig',
  [
 'feeling'=>$feeling
 ,'transactionData'=>$transactionData

]);
}
//  return ['data'=>$data, 'increase'=>$sendMoney, 'decrease'=>$receiveMoney];



}
