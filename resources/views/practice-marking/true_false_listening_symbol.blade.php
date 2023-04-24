

<p>
  <strong><?php
  $answerExists = false;
  if(isset($practise['user_answer']))
  {
        $answerExists = true;
        foreach ($practise['user_answer'][0] as $key => $value) {
            $answers[$key] = $value['true_false'];
        }
        $final_answer = json_encode($answers);
  }
  ?></strong>
</p>

<?php
if(isset($practise['typeofdependingpractice']) && !empty($practise['is_dependent']) && $practise['is_dependent'] == true && isset($practise['dependingpractiseid']) && isset($practise['typeofdependingpractice']) && $practise['type']=="true_false_listening_symbol" ) {
    $depend =explode("_",$practise['dependingpractiseid']);
    // dd($practise);
    ?>

    @include('practice.true_false_listening_symbol_dependancy')       

<?php } else {  ?>

    @include('practice.true_false_listening_symbol_normal')
  
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5media/1.1.8/html5media.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.5.6/plyr.min.js"></script>
<!-- <script src="{{ asset('public/js/audioplayer.js') }}"></script> -->
