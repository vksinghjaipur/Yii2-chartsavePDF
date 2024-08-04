<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Posts;
use Mpdf\Mpdf;

class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

   


       

    //Note: koi bhi view file open karne ke liye same name se folder banana h aur render me folder ka name nahi dena h kewal file ka naam dena h. folder aur controller ka name same hona chahiye

    public function actionIndex()
    {
        $posts = Posts::find()->all();
        //echo '<pre>'; print_r($posts); die();

        return $this->render('index', ['posts' =>$posts]);
    }


    public function actionCreate()
    {
        //echo "Create Post";

        // Create a new Posts model instance
        $posts = new Posts();

        // Check if the request is a POST request and if form data is present
        if (Yii::$app->request->isPost) {
            // Get all POST data
            $formData = Yii::$app->request->post();

            // Print form data for debugging
            //echo '<pre>'; print_r($formData); die();

            // Load the POST data into the model
            if ($posts->load($formData)) {
                // Save the model and redirect on success
                if ($posts->save()) {
                    Yii::$app->getSession()->setFlash('message', 'Posts Published Successfully');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->getSession()->setFlash('message', 'Posts Not Published');
                }
            }
        }

        return $this->render('create', ['posts' => $posts]);

    }



    public function actionView($id){
        //echo "View page"; die();
        $posts = Posts::findOne($id);
        return $this->render('view', ['posts' => $posts]);
    }


    public function actionUpdate($id){
        //echo "edit page";
        $posts = Posts::findOne($id);
        if($posts->load(Yii::$app->request->post()) && $posts->save() ){
            Yii::$app->getSession()->setFlash('message', 'Posts Updated Successfully');
            return $this->redirect(['index', 'id'=> $posts->id]);
        }else{
            return $this->render('edit', ['posts' => $posts]);
        }
    }


    public function actionDelete($id){
        //echo $id;
        $posts = Posts::findOne($id)->delete();
        if($posts){
            Yii::$app->getSession()->setFlash('message', 'Post Delete Successfully');
            return $this->redirect(['index']);
        }
    }


    //V pdf generate by id ye button delete ke baad h
    public function actionGenPdf($id)
    {
        // Find the post by ID
        $posts = Posts::findOne($id);
        if ($posts === null) {
            throw new NotFoundHttpException('The requested post does not exist.');
        }

        $imagePath = Yii::getAlias('@webroot/images/canvaschart.png');

        // Prepare the content for the PDF
        $pdf_content = $this->renderPartial('mypdf', [
            'posts' => $posts,
            'imagePath' => $imagePath // Pass the image path to the view
        ]);

        $mpdf = new \Mpdf\Mpdf();

        // Write HTML to the PDF
        $mpdf->WriteHTML($pdf_content);

        // Output the PDF
        $mpdf->Output();
        exit;
    }



    // 2. Pahle canvas image banakar chart ko save karaya pdf me liye
    public function actionSaveCanvaschart()
    {
        if (Yii::$app->request->isPost) {
            $imageData = Yii::$app->request->post('image');

            // Decode the image data
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $imageData = base64_decode($imageData);

            // Set file path
            $filePath = Yii::getAlias('@webroot/images/canvaschart.png');
            echo 'File Path: ' . $filePath; // Debugging file path

            // Save the image to a file
            if (file_put_contents($filePath, $imageData)) {
                return 'Image saved successfully.';
            } else {
                return 'Failed to save image.';
            }
        }

        return 'Invalid request.';
    }

  





    // Pdf start here............................................................

    // V same page pdf generate
    public function actionGenMypdf()
    {
        // echo "hello"; die();
        // Render the view into $pdf_content
        $pdf_content = $this->render('my-pdf');
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($pdf_content);
        $mpdf->Output();
        exit;
    }




     //V pdf generate by page contents jitana dikhana chaho
    public function actionGenPdfcontent()
    {
        //echo "Hello pdf"; die();
        $posts = Posts::find()->all();
        if (empty($posts)) {
            throw new NotFoundHttpException('No posts found.');
        }
        $html = $this->renderPartial('pdf-contents', ['posts' => $posts]);
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        $mpdf->Output('filename.pdf', 'I'); // 'D' for download, 'I' for inline, 'F' for save to file

        Yii::$app->end();
    }




}
