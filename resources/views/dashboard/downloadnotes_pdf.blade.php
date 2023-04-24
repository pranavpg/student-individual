<style>table, th { border: 1px solid black;  }</style>
<table width="100%">
   <tr>
      <td colspan="5" align="center">Notes</td>
   </tr>
   <tr>
      <td colspan="5"><?php echo 'Student Id:-'.' '.Session::get('user_id_new');?>
      </td>
   </tr>
   <tr style="background-color:black;color:white;">
      <td>Title</td>
      <td>Description</td>
      <td>Topic</td>
      <td>Task</td>
      <td>Skill</td>
   </tr>
   @if(!empty($notes))
   @foreach($notes as $note)                            
   <tr>
      <td title="Title">{{ $note['notetitle'] }}</td>
      <td title="Title">{{ $note['notedescription'] }}</td>
      <td title="Topic">{{ $note['topic']['topicname'] }}</td>
      <td title="Task">{{ $note['task']['taskname'] }}</td>
      <td title="Skill">{{ $note['skill']['skilltitle'] }}
   </tr>
   @endforeach
   @else
   <tr>
      <td colspan="5">No Records Found</td>
   </tr>
   @endif
   <!-- tab 1-->
</table>