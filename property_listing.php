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
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search properties...">
                <button type="submit">Search</button>
            </form>
        </div>

    </header>
    <section id="propertySection" class="property-list">
        <?php

        $searchQuery = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

        $query = "SELECT * FROM properties";


        if (!empty($searchQuery)) {
            $query .= " WHERE name LIKE '%$searchQuery%' 
                        OR type LIKE '%$searchQuery%' 
                        OR size LIKE '%$searchQuery%' 
                        OR location LIKE '%$searchQuery%'";
        }


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

        function fetchProperties(type) {
            fetch(`fetch_properties.php?type=${type}`)
                .then(response => response.json())
                .then(properties => {
                    propertySection.innerHTML = '';
                    if (properties.length > 0) {
                        properties.forEach(property => {
                            const propertyCard = `
                        <div class="property-card">
                            <img src="${property.image}" alt="Property">
                            <div class="details">
                                <h3>Name: ${property.name}</h3>
                                <p>Location: ${property.location}</p>
                                <p>Size: ${property.size}</p>
                                <p>Type: ${property.type}</p>
                                <p class="price">Price: ${property.price}</p>
                                <p class="agent">Agent: <span>${property.agent_name}</span> | Contact: <span>${property.agent_contact}</span></p>
                                <a href="edit_property.php?id=${property.id}" class="btn edit-btn">Edit</a>
                                <a href="delete_property.php?id=${property.id}" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
                            </div>
                        </div>`;
                            propertySection.innerHTML += propertyCard;
                        });
                    } else {
                        propertySection.innerHTML = '<p>No properties found.</p>';
                    }
                })
                .catch(error => console.error('Error fetching properties:', error));
        }

        hireButton.addEventListener('click', () => fetchProperties('Hire'));
        saleButton.addEventListener('click', () => fetchProperties('Sale'));
    </script>
</body>

</html>