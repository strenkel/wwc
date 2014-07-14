<p>
  The WEB WORKER CONTEST is a JavaScript <a target="_blank" href="http://en.wikipedia.org/wiki/Programming_game">programming game</a>.
  On a playing area of 100 x 100 square fields two JavaScript programs compete against each other.
  From a randomly allotted starting point they must conquer as many fields as possible.
  The winner is who occupies most fields at the end. A move is to conquer from the current field either the upper,
  lower, right or left adjacent field. The new field can be occupied only if it was not previously occupied by the opponent's program.
  If a move is possible (the new field is free) the current position changes to the desired field. If a move is not possible
  (the field is occupied by the opponent or you want to leave the playing area), you stay on the current position. Fields that one
  has previously occupied can be used again (but do not count double). The programs do not have any information about the playing area.
  They can not see the playing area. They move blind. The only information they receive is whether their chosen move is possible or not.
  The programs do not move alternately, but as fast as they can. It is therefore important to make fast and intelligent moves.
</p>
<br>
<p>
  The CONTEST is realized with the help of <a target="_blank" href="http://en.wikipedia.org/wiki/Web_worker">Web Workers</a>.
  Web Workers are JavaScript programs in a separate file, which run concurrently in the background.
  Thus, it is possible that the Web Workers play simultaneously. Two compete against each other.
  On the Game page under "Select web workers | test your own web worker" you choose which workers play against each other.
  With the "Local file" option you can compete your own Web Worker against any other. Your own Web Worker is simply a local JavaScript
  file with appropriate code. In this case your own Web Worker is not uploaded to the server. This option is primarily
  for testing and optimizing your own Web Worker. If you want to participate in the WWC you have to upload your Worker on the Upload page.
  After that you can see your Worker as a challenger on the Top30 & Challenger page. On a local super-user computer your Worker
  competes against the Top 30. Depending on the placement he ends up in the Top 30 or leaves the CONTEST.
</p>
<br>
<p>
  As a normal user the evaluation of the results takes place only locally.
  The super user has the opportunity to save the results on the server.
  Such a super-user computer will run throughout the CONTESTS and muster the Web Workers against each other.
</p>
<br>
<p>
  How do you program a Web Worker? Web Workers interact with the main program via messages.
  To make a move the Web Worker must send one of the keywords 'up', 'down', 'right' or 'left' to the main program.
  If the move is possible, true is returned, otherwise false. In order to prevent a permanent firing
  the main program sends an ID together with the success message. The Web Worker must return this ID with his next move.
  Without sending a proper ID the Web Worker will be disqualified.
</p>
<br>
<p>
  At the end (bottom or right side) a simple Web Worker example: He goes mostly straight. Was his last move possible,
  he continues in the same direction with a probability of (around) 95%.
  Was his last move not possible, he randomly picks a new direction.
</p>
<br>
<p>
<?php
  if ($withExample) {
    include 'php/txten/example.php';
  }
?>
</p>
<p>
If you copy this code it into a local JavaScript file you have created your first Web Worker.<br>
Now you just need to tune it a little ;-)
</p>
<br>
<br>
<p>
  <u>More details:</u>
</p>
<br>
<p>
  The distribution of the starting point on the playing field is equally distributed.
</p>
<br>
<p>
  The CONTEST is designed for the current browser (Firefox 29, Chrome 35, IE 11). The Top 30 will be played on the current Firefox.
</p>
<br>
<p>
  A game lasts exactly 10,000 moves. (The moves of both Web Workers are counted together).
</p>
<br>
<p>
  In the case of equal points the earlier upload time decides.
</p>
<br>
<br>
<p>
Happy coding!
</p>