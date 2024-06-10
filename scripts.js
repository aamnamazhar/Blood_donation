document.addEventListener('DOMContentLoaded', () => {
  const stories = [
    "Success Story 1: John donated blood and saved 3 lives.",
    "Success Story 2: Jane's donation helped a child recover from surgery.",
    "Success Story 3: Mike's blood donation was a lifeline for a cancer patient.",
    "Success Story 4: Sarah's blood donation helped a mother during childbirth.",
    "Success Story 5: David's regular donations have saved countless lives."
  ];

  let currentStoryIndex = 0;
  const storiesWrapper = document.getElementById('stories');

  // Create story elements
  stories.forEach(story => {
    const storyElement = document.createElement('div');
    storyElement.className = 'story';
    storyElement.textContent = story;
    storiesWrapper.appendChild(storyElement);
  });

  const scrollStories = () => {
    const firstStory = storiesWrapper.firstElementChild;
    const storyWidth = firstStory.offsetWidth;

    storiesWrapper.appendChild(firstStory.cloneNode(true));
    storiesWrapper.removeChild(firstStory);

    storiesWrapper.style.transition = 'none';
    storiesWrapper.style.transform = `translateX(0)`;
    storiesWrapper.offsetHeight; // Trigger reflow
    storiesWrapper.style.transition = `transform 15s linear`;
    storiesWrapper.style.transform = `translateX(-${storyWidth}px)`;
  };

  // Initial scroll
  setTimeout(scrollStories, 0);

  // Continuous scroll
  setInterval(scrollStories, 15000); // Adjust time according to story width and desired speed
});
