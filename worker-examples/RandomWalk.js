
onmessage = function (event) {
  var randomNumber = Math.random();
  if (randomNumber < 0.25) {
    var direction = "up";
  } else if (randomNumber < 0.5) {
    direction = "down";
  } else if (randomNumber < 0.75) {
    direction = "left";
  } else {
    direction = "right";
  }
  postMessage({
    id: event.data.id,
    direction: direction
  });
};
