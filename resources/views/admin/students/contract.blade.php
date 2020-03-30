<h1>LearnOn Client Agreement</h1>    
<table>
  <tr>
    <td> User Name:</td>
    <td>&nbsp;</td>
    <td> {{$student -> email }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Signup Date</td>
    <td></td>
    <td> {{ $student -> created_at}}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">First Name: </td>
    <td></td>
    <td>{{$student->fname}}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Last Name:</td>
    <td></td>
    <td> {{$student -> lname}} </td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Telephone:</td>
    <td></td>
    <td> {{$student->home_phone }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Cell / Work phone number:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td> {{$student->cell_phone }}</td>
  </tr>
 <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Home Address:</td>
    <td></td>
    <td> {{$student -> address }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">City:</td>
    <td></td>
    <td> {{$student->city }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px"> State/Province:</td>
    <td></td>
    <td> {{$student->state() -> first()['name'] }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px"> Postcode:</td>
    <td></td>
    <td> {{$student->pcode }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">Country:</td>
    <td></td>
    <td> {{$student->country()->first()['name'] }}</td>
  </tr>
  <tr>
      <td></td>
      <td></td>
      <td></td>
  </tr>
  <tr>
    <td height="40px">E-Mail:</td>
    <td>&nbsp;</td>
    <td> {{$student->email }}</td>
  </tr>
  </table>