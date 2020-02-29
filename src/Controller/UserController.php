<?php

namespace App\Controller;

use App\Entity\Msg;
use App\Entity\Loan;
use App\Entity\User;
use App\Entity\CreditorLoan;
use App\DataFixtures\UserFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Mime\Email;
class UserController extends AbstractController
{

public $dir='1home Loan';
  private $passwordEncoder;
private $router;
private $session;
private $entityManager;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder
, RouterInterface $router,SessionInterface $session,EntityManagerInterface $entityManager){
$this->router = $router;
      $this->passwordEncoder = $passwordEncoder;
      $this->session = $session;
      $this->entityManager = $entityManager;
    }


    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
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

  //   /**
  //    * @Route("/register", name="register")
  //    */
  //   public function register(Request $request,UserPasswordEncoderInterface $encoder)
  // {
  //     // // whatever *your* User object is
  //      $user = new User();
  //     $form = $this->createFormBuilder($user)
  //                 ->add('name', TextType::class)
  //                // ->add('dueDate', DateType::class)
  //                ->add('save', SubmitType::class)
  //                ->getForm();
  //     // $form= $this->createForm();//
  //      $form->handleRequest($request);
  //      if($form->isSubmitted() && $form->isValid() ){
  //
  //        $encoded = $encoder->encodePassword($user, $user->getplainPassword);
  //        $user->setPassword($encoded);
  //      }
  //
  //
  //
  // }
    /**
     * @Route("/user/new", name="new user")
     */
    public function createUser(ValidatorInterface $validator ): Response
   {


     // // you can fetch the EntityManager via $this->getDoctrine()
     //       // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
     $entityManager = $this->getDoctrine()->getManager();
     //
           $user = new User();
              $user->setUserName('hassanharby');

           $user->setname('hasan');
           $user->setaddress('199');
           $user->setmail('asa20000928@gmail.com');


$user->setIsAdmin(0);
        $user->setPassword($this->passwordEncoder->encodePassword($user,  'new' ));

           $errors = $validator->validate($user);
       if (count($errors) > 0) {
           return new Response((string) $errors, 400);
       }
       // // tell Doctrine you want to (eventually) save the Product (no queries yet)
       $entityManager->persist($user);

       // actually executes the queries (i.e. the INSERT query)
       $entityManager->flush();

       return new Response('asdasd',200);

     // return new Response('Saved new product with id '.$user->getId());
 // // return new Response('new  ' );
  }
//   /**
//    * @Route("/Loan/", name="")
//    */
//   public function indexLoan(Request $request )
//   {
// //   $loan = new Loan();
// //
// //    // // you can fetch the EntityManager via $this->getDoctrine()
// //    //       // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
// //    $entityManager = $this->getDoctrine()->getManager();
// //
// //          $form = $this->createFormBuilder($loan)
// //                        ->add('Debtor', TextType::class)
// //                        ->add('Creditor', TextType::class)
// //                        ->add('First_Guarantor', TextType::class)
// //
// //                         ->add('Second_Guarantor', TextType::class)
// //                            ->add('money', TextType::class)
// //                        ->add('startDate', DateType::class)
// //                        ->add('endDate', DateType::class)
// //                       ->add('save', SubmitType::class)
// //                       ->getForm();
// //           //  $form= $this->createForm();
// //             $form->handleRequest($request);
// //
// //
// //             if($form->isSubmitted() && $form->isValid() ){
// //
// // //            $repository = $this->getDoctrine()->getRepository(Loan::class);
// //
// //
// //
// //        $entityManager->persist($loan);
// //
// //        // actually executes the queries (i.e. the INSERT query)
// //        $entityManager->flush();
//   // return new RedirectResponse( $this->router->generate('home') );
//   // }
//
//
// //  return $this->render('security/Registerpage.html.twig',['form' => $form->createView() ]);
//
//
//   }

  /**
   * @Route("/Loan/new", name="new loan")
   */
  public function createLoan(Request $request )
  {
  $loan = new Loan();

   // // you can fetch the EntityManager via $this->getDoctrine()
   //       // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
   $entityManager = $this->getDoctrine()->getManager();

         $form = $this->createFormBuilder($loan)
                       ->add('Debtor', TextType::class)
                       ->add('Creditor', TextType::class)
                       ->add('First_Guarantor', TextType::class)

                        ->add('Second_Guarantor', TextType::class)
                           ->add('money', TextType::class)
                       ->add('startDate', DateType::class)
                       ->add('endDate', DateType::class)
                      ->add('save', SubmitType::class)
                      ->getForm();
          //  $form= $this->createForm();
            $form->handleRequest($request);


            if($form->isSubmitted() && $form->isValid() ){

//            $repository = $this->getDoctrine()->getRepository(Loan::class);



       $entityManager->persist($loan);

       // actually executes the queries (i.e. the INSERT query)
       $entityManager->flush();
  return new RedirectResponse( $this->router->generate('home') );
  }


  return $this->render('security/Registerpage.html.twig',['form' => $form->createView() ]);


  }
  /**
   * @Route("/Loan/edit/{id}", name="edit Loan")
   */
  public function editLoan(Loan $loan ,Request $request )
  {


   // // you can fetch the EntityManager via $this->getDoctrine()
   //       // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
   $entityManager = $this->getDoctrine()->getManager();


            $form = $this->createFormBuilder($loan)
                          ->add('Debtor', TextType::class)
                          ->add('Creditor', TextType::class)
                          ->add('First_Guarantor', TextType::class)

                           ->add('Second_Guarantor', TextType::class)
                              ->add('money', TextType::class)
                          ->add('startDate', DateType::class)
                          ->add('endDate', DateType::class)
                         ->add('save', SubmitType::class)
                         ->getForm();
          //  $form= $this->createForm();
            $form->handleRequest($request);


            if($form->isSubmitted() && $form->isValid() ){
       $entityManager->flush();
  return new RedirectResponse( $this->router->generate($this->dir) );
  }


  return $this->render('security/Registerpage.html.twig',['form' => $form->createView() ]);


  }
  /**
   * @Route("/Loan/edit/Creditor/{id}", name="edit Creditor")
   */
  public function editCreditor(Loan $loan ,Request $request )
  {

   $entityManager = $this->getDoctrine()->getManager();
   $form = $this->createFormBuilder($loan)
    ->add('Creditor', TextType::class)
    ->add('save', SubmitType::class)
    ->getForm();
    $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid() ){
   $entityManager->flush();
  return new RedirectResponse( $this->router->generate($this->dir) );
  }
  return $this->render('security/Registerpage.html.twig',['form' => $form->createView() ]);
  }
  /**
   * @Route("/Loan/edit/money/{id}", name="edit money")
   */
  public function editmoney(Loan $loan ,Request $request )
  {

   $entityManager = $this->getDoctrine()->getManager();
   $form = $this->createFormBuilder($loan)
    ->add('money', TextType::class)
    ->add('save', SubmitType::class)
    ->getForm();
    $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid() ){
   $entityManager->flush();
  return new RedirectResponse( $this->router->generate($this->dir) );
  }
  return $this->render('security/Registerpage.html.twig',['form' => $form->createView() ]);
  }
  /**
   * @Route("/Loan/edit/First_Guarantor/{id}", name="edit First_Guarantor")
   */
  public function editFirst_Guarantor(Loan $loan ,Request $request )
  {

   $entityManager = $this->getDoctrine()->getManager();
   $form = $this->createFormBuilder($loan)
    ->add('First_Guarantor', TextType::class)
    ->add('save', SubmitType::class)
    ->getForm();
    $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid() ){
   $entityManager->flush();
  return new RedirectResponse( $this->router->generate($this->dir) );
  }
  return $this->render('security/Registerpage.html.twig',['form' => $form->createView() ]);
  }
  /**
   * @Route("/Loan/edit/Second_Guarantor/{id}", name="edit Second_Guarantor")
   */
  public function editSecond_Guarantor(Loan $loan ,Request $request )
  {
 //return new Response(    $this->dir );
   $entityManager = $this->getDoctrine()->getManager();
   $form = $this->createFormBuilder($loan)
    ->add('Second_Guarantor', TextType::class)
    ->add('save', SubmitType::class)
    ->getForm();
    $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid() ){
   $entityManager->flush();
  return new RedirectResponse( $this->router->generate($this->dir) );
  }
  return $this->render('security/Registerpage.html.twig',['form' => $form->createView() ]);
  }

  // hassan , new
  // $passGiven = new -> encode
  //$user = select from db where username == request('username')
  //$userRealPassword = $user->password;
  // $passGiven == $userRealPassword ? 'DONE' : 'sorry credntials didn't match'

   /**
    * @Route("/user/all", name="all user")
    */
    public function all()
    {
      $repository = $this->getDoctrine()->getRepository(User::class);

     $users = $repository->findAll();


     return $this->render('user/all.html.twig',[
          'users'=>$users ]) ;
         return new Response('Saved new product with id ' );
    }
    /**
     * @Route("/Loan/all", name="h Loan")
     */
     public function allLoan()
     {

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
if($key->getCreditor())
   $userCreditor = $repository->find(['id' => $key->getCreditor() ]);
  if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
  if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
    if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);

    array_push($data,['Creditor' => [ 'id' => ($userCreditor) ? $userCreditor->getId() : 0 , 'name' => ($userCreditor) ? $userCreditor->getname(): ' '  ]
     ,'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
      , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
      , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate()->format('Y-m-d \ h:i:s') : ' '
,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate()->format('Y-m-d \ h:i:s') : ' '
  , 'id'=>  $key->getId()      ] );
      }
      return $this->render('Loan/all.html.twig',[
           'data'=>$data ]) ;

     }
     /**
      * @Route("/Loan/state0", name="state0 Loan")
      */
      public function state0()
      {
        $repository = $this->getDoctrine()->getRepository(Loan::class);

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
    if($key->getCreditor())
    $userCreditor = $repository->find(['id' => $key->getCreditor() ]);
    if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
    if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
    if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);

    array_push($data,['Creditor' => [ 'id' => ($userCreditor) ? $userCreditor->getId() : 0 , 'name' => ($userCreditor) ? $userCreditor->getname(): ' '  ]
    ,'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
    , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
    , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
    ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
    ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate()->format('Y-m-d \ h:i:s') : ' '
    ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate()->format('Y-m-d \ h:i:s') : ' '
    , 'id'=>  $key->getId()      ] );
    }
    return $this->render('Loan/state0.html.twig',[
         'data'=>$data ]) ;




      }
      /**
       * @Route("/Loan/edit/state0To1/{id}", name="edit state0")
       */
      public function editstate(Loan $loan )
      {

       $entityManager = $this->getDoctrine()->getManager();

      $loan->setState(1);
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Mailer = "smtp";
      $mail->SMTPDebug  = 1;
      $mail->SMTPAuth   = TRUE;
      $mail->SMTPSecure = "tls";
      $mail->Port       = 587;
      $mail->Host       = "smtp.gmail.com";

      $mail->Username   = "asa20000928@gmail.com";
      $mail->Password   = "7a3123456";
     $mail->IsHTML(true);
//$mail->AddAddress("ma7moud3mad88@gmail.com", "recipient-name");
$mail->AddAddress("asa20000928@gmail.com", "recipient-name");
$mail->SetFrom("from-email@gmail.com", "from-name");
//$mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
$mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

$mail->MsgHTML($content);
if(!$mail->Send()) {
  return new Response('n ' );
//  var_dump($mail);
} else {
  echo "Email sent successfully";
}

//       $message = (new \Swift_Message('You Got Mail!'))
//
//                     ->setTo('asa20000928@gmail.com')
//                     ->setBody(
//                       //  $contactFormData['message'],
// 'hello',
//                          'text/plain'
//                      )
//                  ;
//
//                 $mailer->send($message);
      // $email = (new Email())
      //             ->from('asa20000928@gmail.com')
      //             ->to('ma7moud3mad88@gmail.com')
      //             //->cc('cc@example.com')
      //             //->bcc('bcc@example.com')
      //             //->replyTo('fabien@example.com')
      //             //->priority(Email::PRIORITY_HIGH)
      //             ->subject('Symfony Mailer!')
      //             ->text('Sending emails is fun again!');
      //       //      ->html('<p>See Twig integration for better HTML integration!</p>');
      //
      //         /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
      //         $sentEmail = $mailer->send($email);
      //          $messageId = $sentEmail->getMessageId();


     $entityManager->flush();

      return new RedirectResponse( $this->router->generate($this->dir) );

      }

      /**
       * @Route("/Loan/edit/state0To_1/{id}", name="edit state0to_1")
       */
      public function editstate0To_1(Loan $loan )
      {

       $entityManager = $this->getDoctrine()->getManager();

      $loan->setState(-1);
      // $mail = new PHPMailer();
      // $mail->IsSMTP();
      // $mail->Mailer = "smtp";
      // $mail->SMTPDebug  = 1;
      // $mail->SMTPAuth   = TRUE;
      // $mail->SMTPSecure = "tls";
      // $mail->Port       = 587;
      // $mail->Host       = "smtp.gmail.com";
      //
      // $mail->Username   = "asa20000928@gmail.com";
      // $mail->Password   = "7a3123456";
      // $mail->IsHTML(true);
      // //$mail->AddAddress("ma7moud3mad88@gmail.com", "recipient-name");
      // $mail->AddAddress("asa20000928@gmail.com", "recipient-name");
      // $mail->SetFrom("from-email@gmail.com", "from-name");
      // //$mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
      // //$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
      // $mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
      // $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";
      //
      // $mail->MsgHTML($content);
      // if(!$mail->Send()) {
      // return new Response('n ' );
      // //  var_dump($mail);
      // } else {
      // echo "Email sent successfully";
      // }

      //       $message = (new \Swift_Message('You Got Mail!'))
      //
      //                     ->setTo('asa20000928@gmail.com')
      //                     ->setBody(
      //                       //  $contactFormData['message'],
      // 'hello',
      //                          'text/plain'
      //                      )
      //                  ;
      //
      //                 $mailer->send($message);
      // $email = (new Email())
      //             ->from('asa20000928@gmail.com')
      //             ->to('ma7moud3mad88@gmail.com')
      //             //->cc('cc@example.com')
      //             //->bcc('bcc@example.com')
      //             //->replyTo('fabien@example.com')
      //             //->priority(Email::PRIORITY_HIGH)
      //             ->subject('Symfony Mailer!')
      //             ->text('Sending emails is fun again!');
      //       //      ->html('<p>See Twig integration for better HTML integration!</p>');
      //
      //         /** @var Symfony\Component\Mailer\SentMessage $sentEmail */
      //         $sentEmail = $mailer->send($email);
      //          $messageId = $sentEmail->getMessageId();


      $entityManager->flush();

      return new RedirectResponse( $this->router->generate($this->dir) );

      }

      /**
       * @Route("/Loan/edit/del/{id}", name="del loan")
       */
      public function delloan(Loan $loan  )
      {
    $this->$entityManager->remove($loan);
      $this->$entityManager->flush();
      return new RedirectResponse( $this->router->generate($this->dir) );

      }
    /**
     * @Route("/user/find", name="find user")
     */
     public function fin()
     {
       $repository = $this->getDoctrine()->getRepository(User::class);

     // $users = $repository->findAll();
   //  $id =1;
   // $user_name='hassanharby';
   // $users = $repository->find($user_name);
//   $users = $repository->findOneBy(['user_name' => 'hassanharby']);
   $users = $repository->findOneBy(['id' => 9]);

   if($users)    return new Response('y ' );
else   return new Response('n ' );


     }

     /**
      * @Route("/loan/userHistory/{id}", name="user History")
      */
      public function userHistory(User $user)
      {



        $repository = $this->getDoctrine()->getRepository(Loan::class);
        $repositoryCL = $this->getDoctrine()->getRepository(CreditorLoan::class);

        $Creditors=$repositoryCL->findby(['user' => $user->getId() ]);
      //
    $LoanDebtor = $repository->findBy(['Debtor' => $user->getId()]);

        $LoanFirst_Guarantor= $repository->findBy(['First_Guarantor' => $user->getId()]);
          $LoanSecond_Guarantor= $repository->findBy(['Second_Guarantor' => $user->getId()]);


        $dataLoanDebtor=[];

        $dataLoanFirst_Guarantor=[];
        $dataLoanSecond_Guarantor=[];
$dataLoanCreditor=[];
        foreach ($LoanDebtor as $key ) {
          $userSecond_Guarantor=null ;
          $userFirst_Guarantor=null ;
          $userDebtor=null ;
          $userCreditor=null ;
          $repository = $this->getDoctrine()->getRepository(User::class);
        if($key->getCreditor())
        $userCreditor = $repository->find(['id' => $key->getCreditor() ]);
        if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
        if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
        if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);

        array_push($dataLoanDebtor,[
        'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
        , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
        , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
        ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
        ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate() : ' '
        ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate() : ' '
        , 'id'=>  $key->getId()      ] );
        }



        foreach ($Creditors as $keyCL ) {
    $repository = $this->getDoctrine()->getRepository(Loan::class);
          $key = $repository->find(['id' => $keyCL->getLoan() ]);

          $userSecond_Guarantor=null ;
          $userFirst_Guarantor=null ;
          $userDebtor=null ;

          $repository = $this->getDoctrine()->getRepository(User::class);

        if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
        if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
        if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);


             array_push($dataLoanCreditor,[ 'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
             , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
             , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
             ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
             ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate() : ' '
             ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate() : ' '
             , 'id'=>  $key->getId()      ] );
        }

        foreach ($LoanFirst_Guarantor as $key ) {
          /// date  red-green-yellow           remaining amount - the amount paid
          $userSecond_Guarantor=null ;
          $userFirst_Guarantor=null ;
          $userDebtor=null ;
          $userCreditor=null ;
          $repository = $this->getDoctrine()->getRepository(User::class);
        if($key->getCreditor())
        $userCreditor = $repository->find(['id' => $key->getCreditor() ]);
        if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
        if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
        if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);

        array_push($dataLoanFirst_Guarantor,[ 'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
        , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
        , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
        ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
        ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate() : ' '
        ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate() : ' '
        , 'id'=>  $key->getId()      ] );
        }
        foreach ($LoanSecond_Guarantor as $key ) {
          $userSecond_Guarantor=null ;
          $userFirst_Guarantor=null ;
          $userDebtor=null ;
          $userCreditor=null ;
          $repository = $this->getDoctrine()->getRepository(User::class);
        if($key->getCreditor())
        $userCreditor = $repository->find(['id' => $key->getCreditor() ]);
        if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
        if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
        if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);

        array_push($dataLoanSecond_Guarantor,[ 'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
        , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
        , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
        ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
        ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate() : ' '
        ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate() : ' '
        , 'id'=>  $key->getId()      ] );
        }

      // $users = $repository->findAll();
    //  $id =1;
    // $user_name='hassanharby';
    // $users = $repository->find($user_name);
 //   $users = $repository->findOneBy(['user_name' => 'hassanharby']);


      return $this->render('user/showUserHistory.html.twig',[
           'dataLoanDebtor'=>$dataLoanDebtor
           ,'dataLoanCreditor'=>$dataLoanCreditor
            ,'dataLoanFirst_Guarantor'=>$dataLoanFirst_Guarantor
             ,'dataLoanSecond_Guarantor'=>$dataLoanSecond_Guarantor ]) ;

      }


      /**
       * @Route("/loan/userGuarantor", name="user Guarantor")
       */
       public function usersGuarantor()
       {



             $repository = $this->getDoctrine()->getRepository(User::class);
               $userCreditors = $repository->findBy(['isGuarantor' => 1 ]);
    $data=[];// user_name name id
     foreach ($userCreditors as $key ) {
       array_push($data , ['id'=> $key->getId() , 'user_name' => $key->getUserName(),  'name' => $key->getname()  ]  );
    }
    //showUsers

    return $this->render('user/showUsers.html.twig',[
         'data'=> $data ,'type'=>'Guarantor(s)'
    ]) ;


       }

       /**
        * @Route("/loan/userCreditor", name="user Creditor")
        */
        public function usersCreditor()
        {



              $repository = $this->getDoctrine()->getRepository(User::class);
                $userCreditors = $repository->findBy(['isCreditor' => 1 ]);
     $data=[];// user_name name id
      foreach ($userCreditors as $key ) {
        array_push($data , ['id'=> $key->getId() , 'user_name' => $key->getUserName(),  'name' => $key->getname()  ]  );
     }
     //showUsers

     return $this->render('user/showUsers.html.twig',[
          'data'=> $data ,'type'=>'Creditor(s)'
     ]) ;


        }
        /**
         * @Route("/loan/userDebtor", name="user Debtor")
         */
         public function usersDebtor()
         {



               $repository = $this->getDoctrine()->getRepository(User::class);
                 $userCreditors = $repository->findBy(['isDebtor' => 1 ]);
      $data=[];// user_name name id
       foreach ($userCreditors as $key ) {
         array_push($data , ['id'=> $key->getId() , 'user_name' => $key->getUserName(),  'name' => $key->getname()  ]  );
      }
      //showUsers

      return $this->render('user/showUsers.html.twig',[
           'data'=> $data ,'type'=>'Debtor(s)'
      ]) ;


         }

         /**
          * @Route("/loan/askCreditor/{id}", name="ask Creditor")
          */
          public function askCreditor(User $user,Request $request)
          {

$msg= new Msg();
 $msg->setUserTo($user->getId());

           $entityManager = $this->getDoctrine()->getManager();
      $form = $this->createFormBuilder($msg)
   ->add('userTo', TextType::class )
    ->add('text', TextType::class)
  ->add('LoanId', TextType::class)
    ->add('send', SubmitType::class)
       ->getForm();

     $form->handleRequest($request);
     $msg->setWatch(0);
     $msg->setTypeMsg(1);
     if($form->isSubmitted() && $form->isValid() ){

   $entityManager->persist($msg);

    $entityManager->flush();
   return new RedirectResponse( $this->router->generate('home') );
 }

       //showUsers

       return $this->render('security/Registerpage.html.twig',[
            'form'=>  $form->createView()
       ]) ;


          }

          /**
           * @Route("/loan/show/{id}", name="show loan")
           */
           public function showLoan(Loan $key)
           {




               $userSecond_Guarantor=null ;
               $userFirst_Guarantor=null ;
               $userDebtor=null ;
               $userCreditor=null ;
               $repository = $this->getDoctrine()->getRepository(User::class);
             if($key->getCreditor())
             $userCreditor = $repository->find(['id' => $key->getCreditor() ]);
             if($key->getDebtor())  $userDebtor = $repository->find(['id' =>$key->getDebtor()  ]);
             if($key->getFirstGuarantor() )   $userFirst_Guarantor = $repository->find(['id' =>$key->getFirstGuarantor() ]);
             if( $key->getSecondGuarantor())  $userSecond_Guarantor = $repository->find(['id' => $key->getSecondGuarantor() ]);

             $data = ['Creditor' => [ 'id' => ($userCreditor) ? $userCreditor->getId() : 0 , 'name' => ($userCreditor) ? $userCreditor->getname(): ' '  ]
             ,'Debtor' => [ 'id' =>  ($userDebtor) ? $userDebtor->getId() : 0 , 'name' => ($userDebtor) ? $userDebtor->getname() : ' '  ]
             , 'First_Guarantor' => [ 'id' =>  ($userFirst_Guarantor) ? $userFirst_Guarantor->getId() : 0 , 'name' => ($userFirst_Guarantor) ? $userFirst_Guarantor->getname(): ' '  ]
             , 'Second_Guarantor' =>[ 'id' =>  ($userSecond_Guarantor) ? $userSecond_Guarantor->getId() : 0 , 'name' => ($userSecond_Guarantor) ? $userSecond_Guarantor->getname(): ' '  ]
             ,'money' => ($key->getMoney() ) ? $key->getMoney() : ' '
             ,'startDate' =>  ($key->getStartDate()) ? $key->getStartDate() : ' '
             ,'endDate' =>  ($key->getEndDate()) ? $key->getEndDate() : ' '
             , 'id'=>  $key->getId()      ] ;



           return $this->render('Loan/show.html.twig',[
                'loan'=>$data ]
                 ) ;

           }
           /**
            * @Route("/loan/AcceptCreditor", name="Accept Creditor")
            */
            public function AcceptCreditor()
            {

    $msg= new Msg();


             $entityManager = $this->getDoctrine()->getManager();


 $msg->setText('Accept');
       $msg->setWatch(0);
       $msg->setTypeMsg(0);


     $entityManager->persist($msg);

      $entityManager->flush();
   return new RedirectResponse( $this->router->generate('home') );

            }
            /**
            *@Route("/user/editAccount-page/{id}",name="editAccount-page")
            */
            public function editAccountPage(User $user)
            {

            //  return $this->render('user/editAccount-page.html.twig',['id'=>$user->getId() ]);
            }


            /**
            *@Route("/ editAccount-submit/{id}",name="editAccount-submit")
            */
            public function  editAccountSubmit(User $user,Request $request)
            {

                $account = $request->request->get('Account');



            $creditorloan= new CreditorLoan();


                  $entityManager = $this->getDoctrine()->getManager();

            $user->setMoney($account);

                $entityManager->flush();
              return new RedirectResponse( $this->router->generate($this->dir) );

            }

            /**
            *@Route("/laon/editEndDate-page/{id}",name="editEndDate-page")
            */
            public function editEndDatePage(User $user)
            {

              return $this->render('loan/editEndDate-page.html.twig',['id'=>$user->getId() ]);
            }


            /**
            *@Route("/editEndDate-submit/{id}",name="editEndDate-submit")
            */
            public function  editEndDateSubmit(Loan $loan,Request $request)
            {

                $EndDate = $request->request->get('EndDate');



                  $entityManager = $this->getDoctrine()->getManager();

            $loan->setEndDate(new \DateTime($EndDate));

                $entityManager->flush();
              return new RedirectResponse( $this->router->generate($this->dir) );

            }

//////



   }
