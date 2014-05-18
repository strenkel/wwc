var direction = "up";

onmessage = function (event) {
  var randomNumber = Math.random();
  if (randomNumber < 0.1) {
    direction = "up";
  } else if (randomNumber < 0.2) {
    direction = "down";
  } else if (randomNumber < 0.3) {
    direction = "left";
  } else if (randomNumber < 0.4) {
    direction = "right";
  }
  postMessage({
    id: event.data.id,
    direction: direction
  });
};
