var direction = "up";

onmessage = function (event) {
  var randomNumber = Math.random();
  if (randomNumber < 0.07) {
    direction = "up";
  } else if (randomNumber < 0.14) {
    direction = "down";
  } else if (randomNumber < 0.21) {
    direction = "left";
  } else if (randomNumber < 0.28) {
    direction = "right";
  }
  postMessage({
    id: event.data.id,
    direction: direction
  });
};
