<!DOCTYPE html>
<html lang="en">
<?php include 'databaseconnect.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Estates - Property Listing</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .menu {
            display: flex;
            gap: 20px;
        }

        .menu a,
        .menu button {
            background-color: #34495e;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .menu a:hover,
        .menu button:hover {
            background-color: #1abc9c;
        }

        .details a,
        .details button {
            background-color: #34495e;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        
        .details a {
            margin-top: 30px;
        }

        .search-filter {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-filter input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-filter button {
            background-color: #1abc9c;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .search-filter button:hover {
            background-color: #16a085;
        }

        /* Property Listing Section */
        .property-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .property-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .property-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .property-card .details {
            padding: 15px;
        }

        .property-card .details h3 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .property-card .details p {
            margin: 5px 0;
            color: #555;
        }

        .property-card .details .price {
            color: #1abc9c;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <h1>Elite Estates</h1>
        <div class="menu">
            <a href="index.html">Home</a>
            <button id="hireButton">For Hire</button>
            <button id="saleButton">For Sale</button>
            <a href="add_property.php">Add Property</a>
        </div>
        <div class="search-filter">
            <input type="text" placeholder="Search properties...">
            <button>Search</button>
        </div>
    </header>
    <section id="propertySection" class="property-list">
        <?php
        $query = "SELECT * FROM properties";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="property-card">
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Property">

                    <div class="details">
                        <h3>Name: <?php echo htmlspecialchars($row['name']); ?></h3>
                        <p>Location: <?php echo htmlspecialchars($row['location']); ?></p>
                        <p>Size: <?php echo htmlspecialchars($row['size']); ?> </p>
                        <p>Type: <?php echo htmlspecialchars($row['type']); ?></p>
                        <p class="price">Price: <?php echo htmlspecialchars($row['price']); ?></p>
                        <p class="agent">Agent: <span><?php echo htmlspecialchars($row['agent_name']); ?></span> | Contact: <span><?php echo htmlspecialchars($row['agent_contact']); ?></span></p>


                        <a href="edit_property.php?id=<?php echo $row['id']; ?>" class="btn edit-btn">Edit</a>
                        <a href="delete_property.php?id=<?php echo $row['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>

                    </div>
                </div>
        <?php
            }
        } else {
            echo "<p>No properties found.</p>";
        }
        ?>



    </section>
    <script>
        const hireButton = document.getElementById('hireButton');
        const saleButton = document.getElementById('saleButton');
        const propertySection = document.getElementById('propertySection');

        hireButton.addEventListener('click', () => {
            propertySection.innerHTML = `
              <div class="property-card">
        <img src="images/studio.jpeg" alt="Property">
        <div class="details">
            <h3>Studio Apartment</h3>
            <p>Location: Mirema Drive</p>
            <p>1 Bed 1 Bathroom</p>
            <p class="price">$100/month</p>
            <p class="agent">Agent: <span>DRE</span> | Contact: <span>(254) 123-45678</span></p>
        </div>
    </div>
              <div class="property-card">
                  <img src="https://via.placeholder.com/300" alt="Property">
                  <div class="details">
                      <h3>Cozy Studio</h3>
                      <p>Location: San Francisco</p>
                      <p class="price">$1,800/month</p>
                  </div>
              </div>
              <div class="property-card">
                  <img src="https://via.placeholder.com/300" alt="Property">
                  <div class="details">
                      <h3>Luxury Loft</h3>
                      <p>Location: Chicago</p>
                      <p class="price">$3,200/month</p>
                  </div>
              </div>`;
        });

        saleButton.addEventListener('click', () => {
            propertySection.innerHTML = `
             <div class="property-card">
          <img src="images/cozzy.jpeg" alt="Property">
          <div class="details">
              <h3>cozzy cottage</h3>
              <p>Location: Karen, Nairobi</p>
              <p>5 Bedrooms 4 Bathroom</p>
              <p class="price">$200,000</p>
              <p class="agent">Agent: <span>Jane Smith</span> | Contact: <span>(254) 987-6543</span></p>
          </div>
      </div>
              <div class="property-card">
      <img src="images/mod.jpeg" alt="Property">
      <div class="details">
          <h3>Modern Apartment</h3>
          <p>Location: Syokimau, Nairobi</p>
          <p>6 Bedrooms 5 Bathroom</p>
          <p class="price">$600,000</p>
          <p class="agent">Agent: <span>Jane Smith</span> | Contact: <span>(254) 123-45678</span></p>
      </div>
  </div>
              <div class="property-card">
                  <img src="https://via.placeholder.com/300" alt="Property">
                  <div class="details">
                      <h3>Country Estate</h3>
                      <p>Location: Vermont</p>
                      <p class="price">$750,000</p>
                  </div>
              </div>`;
        });
    </script>
</body>

</html>