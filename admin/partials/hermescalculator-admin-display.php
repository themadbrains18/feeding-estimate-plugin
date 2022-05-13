<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wppb.me/
 * @since      1.0.0
 *
 * @package    Hermescalculator
 * @subpackage Hermescalculator/admin/partials
 */

 global $post;

 $formFields = array(
     'rer' => [
         'sectionLabel' => 'Calculate (RER)',
         [
             'label' => 'Label',
             'id'    => 'labelId',
             'class' => 'form_input',
             'type'  => 'text'
         ],
         [
            'label' => 'Exponent:',
            'id'    => 'Exponent',
            'class' => 'form_input',
            'type'  => 'number'
        ],
        [
            'label' => 'Multiplier:',
            'id'    => 'Multiplier',
            'class' => 'form_input',
            'type'  => 'number'
        ]
    ],
    'dailyintake' => [
        [
          'label' => 'Amount of raw food for Calories:',
          'id'    => 'Calories',
          'class' => 'form_input',
          'type'  => 'number'
        ],
        [
          'label' => 'Oz.Quantity:',
          'id'    => 'quantity',
          'class' => 'form_input',
          'type'  => 'number'
        ],
        [
          'label' => 'Net Weight(gm):',
          'id'    => 'Weight',
          'class' => 'form_input',
          'type'  => 'number'
        ] 
  ],
  'feeding' => [
        [
          'label' => 'ONCE',
          'id'    => 'once',
          'class' => '',
          'type'  => 'checkbox'
        ],
        [
          'label' => 'TWICE',
          'id'    => 'twice',
          'class' => '',
          'type'  => 'checkbox'
        ],
        [
          'label' => 'THRICE',
          'id'    => 'thrice',
          'class' => '',
          'type'  => 'checkbox'
        ],
  ],
  'der'  => [

  ]

 );



 $saveData =  get_post_meta($post->ID,'saved_formula');
 $dataList = json_decode($saveData[0],true);

 $filterData = [];
 $repeator = [];


 if(!empty($dataList)){
   $lists = array('rer','group-b','dailyintake','feeding','PageRecommendation','ProductRecommendation');
   foreach($dataList as $keys => $values){
      if (in_array($keys,$lists))
      {
      }else{
        unset($dataList[$keys]);
      }
   }
 }



 $filterDataOrignal = $dataList;  // this variable use for side navigation

 $filterData = $dataList;

 if(empty($filterData)){
    $filterData = array('nothing','ProductRecommendation' => array(0));
 }


?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
 <div id="root">
      <section class="hermesRaw_calculator_sec">
        <div class="container">
          <!-- sec content -->
          <div class="sec_content">
            <div class="sec_contet_inner">
              <div class="textarea_wrapper">
                <div class="textarea_inner">
                  <!-- ======= RER Form Start ======= -->
                  <div class="form" id="RERForm">
                    <div class="form_head">
                      <h2 class="sec_heading">Calculate (RER)</h2>
                    </div>
                    <div class="form_content" id="RERformContent">
                      <div class="form_inner">

                        <!-- repeator for ere fields -->
                        <?php 
                            if($formFields['rer']) {
                                foreach($formFields['rer'] as $key => $rer) {
                                    if($key === 'sectionLabel') {continue;} 
                                    extract($rer);
                                    $savedValueRer = '';
                                    if (array_key_exists('rer',$filterData)){
                                      $savedValueRer = $filterData["rer"][$id];
                                    }
                                    echo ' <div class="form_items">
                                    <label for="labelId" class="input_label">'.$label.'</label>
                                    <input type="'.$type.'" value="'.$savedValueRer.'" autocomplete="off" class="'.$class.'" id="'.$id.'" name="rer['.$id.']" />
                                  </div>';
                                }
                            } 
                        ?>
                       
                      </div>
                    </div>
                  </div>
                  <div class="add_Btn">
                    <button type="button" id="addRER">Add RER +</button>
                  </div>
                  <!-- ======= RER Form Start ======= -->

                  <!-- ======= DER Form Start ======= -->
                  <div class="repeater_form" id="DERForm">
                    <h2 class="sec_heading">Calculate (DER)</h2>
                    <div class="repeater">
                      <div data-repeater-list="group-b">

                      <?php 
                      if(!empty($filterData['group-b'])){ 
                        $countRep = 0;
                        foreach($filterData['group-b'] as $repeat) {  
                          ?>
                        <div data-repeater-item class="repeater_item">
                          <div class="label_item">
                            <label class="input_label">Label</label>
                            <input type="text" value="<?php echo $repeat['der-label']; ?>" class="form_input" name="der-label" />
                          </div>
                          <div class="label_item">
                            <label class="input_label">Value</label>
                            <input type="number" name="der-value" class="form_input" value="<?php echo $repeat['der-value']; ?>" />
                          </div>
                          <div class="add_Btn repeater_btn">
                            <input data-repeater-delete type="button" value="Delete">
                          </div>
                        </div>
                      <?php  $countRep++; } } else { ?>

                        <div data-repeater-item class="repeater_item">
                          <div class="label_item">
                            <label class="input_label">Label</label>
                            <input type="text" class="form_input" name="der-label" />
                          </div>
                          <div class="label_item">
                            <label class="input_label">Value</label>
                            <input type="number" name="der-value" class="form_input" value="" />
                          </div>
                          <div class="add_Btn repeater_btn">
                            <input data-repeater-delete type="button" value="Delete">
                          </div>
                        </div>
                      <?php } ?>
                      </div>
                      <div class="add_Btn">
                        <input data-repeater-create type="button" value="Add +">
                      </div>
                    </div>
                  </div>
                  <div class="add_Btn">
                    <button type="button" id="derFormBtn">Add DER +</button>
                  </div>
                  <!-- ======= DER Form End ======= -->

                  <!-- ======= Daily Intake Form Start ======= -->
                  <div class="daily_intake" id="dailyIntake">
                    <h2 class="sec_heading">Calculate (Daily Intake)</h2>
                    <div class="form_inner">
                    <?php 
                            if($formFields['dailyintake']) {
                                foreach($formFields['dailyintake'] as $key => $rer) {
                                    if($key === 'sectionLabel') {continue;} 
                                    extract($rer);
                                    $savedValueDailyIntake = '';
                                    if (array_key_exists("dailyintake",$filterData)){
                                      $savedValueDailyIntake = $filterData["dailyintake"][$id];
                                    }
                                    echo ' <div class="form_items">
                                    <label for="'.$label.'" class="input_label">'.$label.'</label>
                                    <input type="'.$type.'" value="'.$savedValueDailyIntake.'" autocomplete="off" class="'.$class.'" id="'.$id.'" name="dailyintake['.$id.']" />
                                  </div>';
                                }
                            } 
                        ?>
                    </div>
                  </div>
                  <div class="add_Btn">
                    <button type="button" id="dailyIntakeBtn">Add Daily Intake +</button>
                  </div>
                  <!-- ======= Daily Intake Form End ======= -->

                  <!-- ======= Feeding Start ======= -->
                  <div class="calculate_feeding" id="calculateFeeding">
                    <h2 class="sec_heading">Calculate (Feeding)</h2>
                    <div class="repeater_form" id="Feeding">
                    <?php 
                            if($formFields['feeding']) {
                                foreach($formFields['feeding'] as $feedingkey => $feeding) {
                                    extract($feeding);
                                    $savedValueFeeding = '';
                                    if (array_key_exists("feeding",$filterData)){
                                      $savedValueFeeding = $filterData["feeding"][$id];
                                    }
                                    $checked = '';
                                    if($savedValueFeeding){ $checked = 'checked'; }
                                    echo '<div class="form-group">
                                    <input '.$checked.' type="checkbox" id="'.$id.'" value="'.$id.'" name="feeding['.strtolower($id).']" />
                                    <label for="'.$id.'">'.$label.'</label>
                                  </div>';
                                }
                            } 
                        ?>
                    </div>
                  </div>
                  <div class="add_Btn">
                    <button type="button" id="addFeeding">Add Feeding +</button>
                  </div>
                  <!-- ======= Feeding End ======= -->


                  <!-- ============ Product Recommendation  ============= -->
                  <div class="calculate_feeding" id="ProductRecommendation">
                    <h2 class="sec_heading">Calculate (Product Recommendation)</h2>
                    <div class="repeater_form" id="ProductRecommendationInner">
                        <div class="form-group">
                        <?php $query = new WP_Query(array('post_type'=>'product','posts_per_page'=>-1)); ?>
                        <div class="select" style="height:6em">

                        <select name="ProductRecommendation[]" id="ProductRecommendationData"  multiple>
                            <option value="">------ Select Product ------</option>
                            <?php if($query->have_posts()) : while($query->have_posts()) : $query->the_post(); 
                           
                            if (array_key_exists("ProductRecommendation",$filterData)){
                              $savedValueProductRecommendation = $filterData["ProductRecommendation"];
                            }
                            $selected1 = '';
                            if(in_array(get_the_ID(),$savedValueProductRecommendation))
                            {
                             $selected1 = 'selected="selected"';
                            }

                            echo '<option '.$selected1.' value="'.get_the_ID().'">'.get_the_title().'</option>';
                             endwhile; wp_reset_query(); endif;  ?>

                            </select>
                        </div>
                        </div>

                  </div>
                        </div>
                  <div class="add_Btn">
                    <button type="button" id="ProductRecommendation-btn">Product Recommendation +</button>
                  </div>
                  <!-- ============  Product Recommendation End============= -->

                <!-- ============ Apply on page (Quiz)  ============= -->
                <div class="calculate_feeding" id="PageRecommendation">
                    <h2 class="sec_heading">Calculate (Apply on page Quiz)</h2>
                    <div class="repeater_form" id="PageRecommendationInner">
                        <div class="form-group">
                        <?php $page = new WP_Query(array('post_type'=>'page','posts_per_page'=>-1)); ?>
                        <div class="select">
                        <select name="PageRecommendation">
                            <option value="">------ Select Product ------</option>
                            <?php if($page->have_posts()) : while($page->have_posts()) : $page->the_post(); 
                             if (array_key_exists("PageRecommendation",$filterData)){
                               $savedValuePageRecommendation = $filterData["PageRecommendation"];
                             }
                             $selected = '';
                             if($savedValuePageRecommendation == get_the_ID())
                             {
                              $selected = 'selected="selected"';
                             }
                             echo '<option '.$selected.' value="'.get_the_ID().'">'.get_the_title().'</option>';
                             endwhile; wp_reset_query(); endif;  ?>

                            </select>
                        </div>
                        </div>

                  </div>
                        </div>
                  <div class="add_Btn">
                    <button type="button" id="PageRecommendation-btn">Page Recommendation +</button>
                  </div>
                  <!-- ============  Apply on page (Quiz) ============= -->  

                  <div class="add_Btn">
                    <button type="button" id="save_formula-btn">Save Formula</button>
                  </div>

                  

                </div>
                <div class="sidebar_options">
                  <ul>
                    <li step="stepCompleted">
                      <button type="button" class="option" <?php if(!empty($filterDataOrignal)) { echo 'step="stepCompleted"'; }  ?> id="RERoption">RER</button>
                    </li>
                    <li>
                      <button type="button" class="option" id="DERoption"  <?php if(!empty($filterDataOrignal)) { echo 'step="stepCompleted"'; }  ?> >DER</button>
                    </li>
                    <li>
                      <button type="button" class="option" id="dailyIntakeOption" <?php if(!empty($filterDataOrignal)) { echo 'step="stepCompleted"'; }  ?> >Daily Intake</button>
                    </li>
                    <li>
                      <button type="button" class="option" id="Feedingoption" <?php if(!empty($filterDataOrignal)) { echo 'step="stepCompleted"'; }  ?> >Feeding</button>
                    </li>
                    <li>
                      <button class="option" id="ProductRecommendation"  <?php if(!empty($filterDataOrignal)) { echo 'step="stepCompleted"'; }  ?> >
                        Product Recommendation
                      </button>
                    </li>

                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>



    <!-- The Modal -->
    <div id="tmb-myModal" class="tmb-modal">

         <!-- Modal content -->
        <div class="tmb-modal-content">
        <div class="tmb-modal-header">
            <span class="tmb-close">&times;</span>
            <h2>Product Recommendation</h2>
        </div>
        <div class="tmb-modal-body">
              <div id="product-main-wrapper">

                 <?php $loop = new WP_Query(array('post_type'=>'product','posts_per_page'=>-1)); ?>

                  <!-- product grid loop  -->
                  <?php if($loop->have_posts()) : while($loop->have_posts()) : $loop->the_post();
                          $feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
                          $product = wc_get_product( get_the_ID() );
                          $selectedActive = '';

                          if(!empty($filterData)){
                            if (array_key_exists("ProductRecommendation",$filterData)){
                              $savedValueProductRecommendation = $filterData["ProductRecommendation"];
                            }
                            if(in_array(get_the_ID(),$savedValueProductRecommendation))
                            {
                             $selectedActive = 'active';
                            }
                          }

                          
                  ?>
                  <div class="product-grid-loop <?php echo $selectedActive; ?>" data-product_id="<?php echo get_the_ID(); ?>">
                        <div class="product-overlay-tick">
                           <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 512"><path fill="#3AAF3C" d="M256 0c141.39 0 256 114.61 256 256S397.39 512 256 512 0 397.39 0 256 114.61 0 256 0z"/><path fill="#0DA10D" fill-rule="nonzero" d="M391.27 143.23h19.23c-81.87 90.92-145.34 165.89-202.18 275.52-29.59-63.26-55.96-106.93-114.96-147.42l22.03-4.98c44.09 36.07 67.31 76.16 92.93 130.95 52.31-100.9 110.24-172.44 182.95-254.07z"/><path fill="#fff" fill-rule="nonzero" d="M158.04 235.26c19.67 11.33 32.46 20.75 47.71 37.55 39.53-63.63 82.44-98.89 138.24-148.93l5.45-2.11h61.06c-81.87 90.93-145.34 165.9-202.18 275.53-29.59-63.26-55.96-106.93-114.96-147.43l64.68-14.61z"/></svg>
                        </div>
                        <div class="product-image">
                          <img src="<?php echo $feat_image_url; ?>" alt="<?php the_title(); ?>" />
                        </div>
                        <div class="product-meta-content">
                            <h2> <?php the_title(); ?> </h2>
                            <p class="product-price"><?php echo $product->get_price_html(); ?></p>
                        </div>    
                  </div>
                  <?php endwhile; wp_reset_query(); endif; ?>

              </div>
        </div>
        
        </div>
    </div>

    <!-- script links -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    