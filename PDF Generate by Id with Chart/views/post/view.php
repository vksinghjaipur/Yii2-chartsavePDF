<?php 
	use yii\helpers\Html;
	use yii\widgets\DetailView;

?>


<div class="container">
 
  <h2>View Page</h2>
  
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" class="form-control" placeholder="Enter email" name="title" value="<?php echo $posts->title ;?>" disabled>
    </div>

    <div class="form-group">
      <label for="description">Description:</label>
      <textarea class="form-control" rows="5" id="comment"><?php echo $posts->description ;?></textarea>
    </div>

    <div class="form-group">
      <label for="title">Category:</label>
      <input type="text" class="form-control" placeholder="Enter category" name="category" value="<?php echo $posts->category ;?>" disabled>
    </div>
    

    <div class="row">
        <div class="form-group">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-4">
                        <a href=<?php echo yii::$app->homeURL;?> class="btn btn-primary">Go Back </a>
                    </div>
                </div>
        
            </div>
        </div>
    </div>


</div>

