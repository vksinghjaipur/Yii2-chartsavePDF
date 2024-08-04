<?php
  use yii\helpers\Html;
  use yii\widgets\ActiveForm;
?>


<div class="site-content">
  <h1>Create Post</h1>

  <span><?= Html::a('List Data', ['post/post'], ['class' => 'btn btn-warning']) ?></span>

    <div class="body-content mt-2">
      <?php
      $form = ActiveForm::begin()?> 

      <div class="row">
        <div class="form-group">
          <div class="col-lg-6">
            <?= $form->field($posts, 'title'); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <div class="col-lg-6">
            <?= $form->field($posts, 'description')->textarea(['rows' => '4']); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <div class="col-lg-6">
            <?php $items = ['CMS' => 'CMS', 'MVC'=>'MVC', 'e-commerce' =>'e-commerce']; ?>
            <?= $form->field($posts, 'category')->dropDownList($items,['prompt' => 'Select']); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <div class="col-lg-6">
            <div class="row">
            <div class="col-lg-3">
              <?= Html::submitButton('Create Post', ['class'=>'btn btn-success']);?>
            </div>
            <div class="col-lg-4">
              <a href=<?php echo yii::$app->homeURL;?> class="btn btn-primary">Go Back </a>
            </div>
            </div>
        
          </div>
        </div>
      </div>

    <?php ActiveForm::end();?>  
    </div>
    
</div>

