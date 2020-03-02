export const degToCompass = num => {
  const val = Math.round(num / 45) > 7 ? 0 : Math.round(num / 45);
  const arr = ["north", "north east", "east", "south east", "south", "south west", "west", "north west"];
  return arr[val];
};

export const windForce = num => {
  return num >= 10.8 ? "strong" : "soft";
};
