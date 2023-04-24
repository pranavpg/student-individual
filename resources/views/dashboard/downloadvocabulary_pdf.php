<style>table, th { border: 1px solid black;  }</style>
<?php 
   $allvocablist = $vocabularies = array();                                    
   if(!empty($vocablist)){
   foreach($vocablist as $vocab){
   $allvocablist[$vocab['id']] = $vocab['vocabs'];
   if(isset($vocab['vocabs']) && !empty($vocab['vocabs'])){
   foreach($vocab['vocabs'] as $vocabsss){
                   $vocabularies[] = $vocabsss;
               }   
           }  
       }
      }									
   ?>    
<?php 
   // echo "<pre>";print_r($allvocablist); exit;
   $abcdWise = array();
   foreach($vocabularies as $vocabulary){
   	$word = $vocabulary['word'];
   	$wordFirstCharacter = $word[0];
   	$vocabulary['character'] = strtoupper($wordFirstCharacter);
   	$abcdWise[strtoupper($wordFirstCharacter)][] = $vocabulary;
   } ?>
<table width="100%">
   <tr>
      <td colspan="8" align="center">Vocabulary</td>
   </tr>
   <tr>
      <td colspan="8"><?php echo 'Student Id:-'.' '.Session::get('user_id_new'); ?>
      </td>
      <!-- <td colspan="8"><?php //echo 'Student Id:-'.' '.$sessionAll['user_data']['student_id'].' | '.'Student Name:-'.' '.$sessionAll['user_data']['firstname'].' '.$sessionAll['user_data']['lastname'] ?>
         </td> --> 
   </tr>
   <tr style="background-color:black;color:white">
      <td>Word</td>
      <td>Word Type</td>
      <td>Phonetic Transcription</td>
      <td>Meaning</td>
      <td>Sample Sentence 1</td>
      <td>Sample Sentence 2</td>
      <td>Sample Sentence 3</td>
      <td>Sample Sentence 4</td>
   </tr>
   <?php $abcdKeys = array_keys($abcdWise);
      sort($abcdKeys);												
      ?>
   <?php foreach($abcdKeys as $key){
      foreach($abcdWise[$key] as $i=>$voc){
      ?>
   <tr>
      <td><?php echo $voc['word'];?></td>
      <td><?php echo $voc['wordtype'];?></td>
      <td><?php echo $voc['phonetictranscription'];?></td>
      <td><?php echo $voc['translationmeaning'];?></td>
      <td><?php echo $voc['sentence1'];?></td>
      <td><?php echo $voc['sentence2'];?></td>
      <td><?php echo $voc['sentence3'];?></td>
      <td><?php echo $voc['sentence4'];?></td>
   </tr>
   <?php }
      }?>
</table>