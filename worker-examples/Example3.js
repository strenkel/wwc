var direction = "up";

onmessage = function (event) {
  var randomNumber = Math.random();
  if (randomNumber < 0.025) {
    direction = "up";
  } else if (randomNumber < 0.05) {
    direction = "down";
  } else if (randomNumber < 0.075) {
    direction = "left";
  } else if (randomNumber < 0.1) {
    direction = "right";
  }
  postMessage({
    id: event.data.id,
    direction: direction
  });
};
