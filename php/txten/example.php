<pre><code>
var direction;

// Called when the main program
// sends the success message to
// the Web Workers.
onmessage = function (event) {

  // The success message is send with
  // the field 'done' (true | false).
  var done = event.data.done;

  // Determine new direction.
  if (done) {
    direction =
      holdOrChangeDirection(direction);
  } else {
    direction = getRandomDirection();
  }

  // Tells the main program the new
  // direction. The direction is sent
  // with the field 'direction'. The
  // ID is sent with the field 'id'.
  postMessage({
    id: event.data.id,
    direction: direction
  });
};

function holdOrChangeDirection(dir) {
  if (Math.random() &lt; 0.05) {
    return getRandomDirection();
  } else {
    return dir;
  }
}

function getRandomDirection() {
  var randomDirection;
  var randomNumber = Math.random();
  if (randomNumber &lt; 0.25) {
    randomDirection = "up";
  } else if (randomNumber &lt; 0.5) {
    randomDirection = "down";
  } else if (randomNumber &lt; 0.75) {
    randomDirection = "left";
  } else {
    randomDirection = "right";
  }
  return randomDirection;
}

</code></pre>