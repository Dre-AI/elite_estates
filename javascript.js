document.querySelector('.list-home-button').addEventListener('click', () => {
    console.log('List Your Home clicked!');
    // Add redirection logic or modal popup here
  });
  
  document.querySelector('.buy-home-button').addEventListener('click', () => {
    console.log('Buy A Home clicked!');
    // Add redirection logic or modal popup here
  });
  console.log("JavaScript file loaded!");
  // JavaScript for Search Functionality
document.getElementById("searchButton").addEventListener("click", function () {
    const searchValue = document.getElementById("searchInput").value.toLowerCase(); // Get the input value
    const propertyCards = document.querySelectorAll(".property-card"); // Get all property cards
  
    propertyCards.forEach((card) => {
      const propertyTitle = card.querySelector(".property-details h3").textContent.toLowerCase(); // Get the property title
      if (propertyTitle.includes(searchValue)) {
        card.style.display = "block"; // Show matching cards
      } else {
        card.style.display = "none"; // Hide non-matching cards
      }
    });
  });

  
  