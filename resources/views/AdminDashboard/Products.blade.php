 <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Admin - Products</title>
        <link rel="stylesheet" href="DashB_css/products.css">
        <link rel="stylesheet" href="DashB_css/ProductsModal.css">
        <link rel="stylesheet" href="DashB_css/UpdateProductModal.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head>
    <body>
    <div id="app">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <div class="logo">
                    <span>Berde Kopi</span>
                </div>
            </div>
            <div class="header-right">
                <div class="admin-profile">
                    <span class="time">Time</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="currentColor"/>
                        <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="currentColor"/>
                    </svg>
                    <span><strong style="color:green; font-weight:bolder;">Admin: </strong><?= htmlspecialchars($fullname) ?></span>
                </div>
            </div>
        </header>

        <div class="main-container">
            <!-- Sidebar -->
            <aside class="sidebar">
                <nav class="sidebar-nav">
                    <a href="DashboardAdmin.php" class="nav-item"><i class="bi bi-list"></i> Dashboard</a>
                <a href="Products.php" class="nav-item"><i class="bi bi-bag"></i> Products</a>
                <a href="Orders.php" class="nav-item"><i class="bi bi-bag-check-fill"></i> Orders</a>
                <a href="OrderItem.php" class="nav-item"><i class="bi bi-basket"></i> OrderItem</a>
                <a href="Employee.php" class="nav-item"><i class="bi bi-person-circle"></i> Employee</a>
                <a href="Archived.php" class="nav-item"><i class="bi bi-person-x"></i> Archived</a>
                <a href="Inventory.php" class="nav-item"><i class="bi bi-cart-check"></i> Inventory</a>
                <a href="Ingredients.php" class="nav-item"><i class="bi bi-check2-square"></i> Ingredients</a>
                <a href="Supply.php" class="nav-item"><i class="bi bi-box-fill"></i> Supplier</a>
                <a href="Payment.php" class="nav-item"><i class="bi bi-cash-coin"></i> Payment</a>
                <a href="Category.php" class="nav-item"><i class="bi bi-tags"></i> Category</a>
                <a href="../Admin/Authorize.php?logout=1" class="nav-item logout">
                <i class="bi bi-box-arrow-left"></i> Logout
                </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="main-content">
                <div class="products-header">
                    <h1 class="page-title">Products</h1>
                    <button class="add-product-btn">Add Products</button>
                </div>

                <!-- Products Table -->
                <div class="table-container">
                    <table class="products-table">
                        <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Category ID</th>
                            <th>Name</th>
                            <th>Category Name</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (count($products) > 0): ?>
                            <?php foreach ($products as $prod): ?>
                                <tr>
                                    <td><?= htmlspecialchars($prod['Product_id']) ?></td>
                                    <td><?= htmlspecialchars($prod['Category_id']) ?></td>
                                    <td><?= htmlspecialchars($prod['Product_name']) ?></td>
                                    <td><?= htmlspecialchars($prod['Category_name'] ?? 'N/A') ?></td>
                                    <td>₱<?= number_format($prod['Price'], 2) ?></td>
                                    <td><?= !empty($prod['Image']) ? htmlspecialchars(basename($prod['Image'])) : 'No Image' ?></td>

                                    <td>
                                        <?php
                                            $stock = $prod['QuantityInStock'] ?? 0;
                                            if ($stock > 0) {
                                                echo "<span style='color:green; font-weight:bold;'>In Stock ($stock)</span>";
                                            } else {
                                                echo "<span style='color:red; font-weight:bold;'>Out of Stock</span>";
                                            }
                                        ?>
                                    </td>

                                    <td><button class="update-btn" data-product-id="<?= $prod['Product_id'] ?>">Update</button></td>
                                    <td><button class="delete-btn" data-id="<?= $prod['Product_id'] ?>" data-name="<?= htmlspecialchars($prod['Product_name']) ?>">Delete</button></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10">No products found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1 ?>" class="page-btn">Previous</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?>" class="page-btn <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?= $page + 1 ?>" class="page-btn">Next</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>

        <!-- Add Product Modal -->
        <div id="ProductModal" class="modal-overlay">
            <form action="InsertProduct.php" method="POST" enctype="multipart/form-data">
                <h1>Add Products</h1>
                <p>Product name</p>
                <input type="text" name="Product_name" required>

                <p>Category name</p>
                <select name="Category_id" required>
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['Category_id'] ?>"><?= htmlspecialchars($cat['Category_name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <p>Ingredients</p>
                <select name="Ingredient_id" required>
                    <option value="">-- Select Ingredient --</option>
                    <?php foreach ($ingredients as $ing): ?>
                        <option value="<?= $ing['Ingredient_id'] ?>"><?= htmlspecialchars($ing['Ingredient_name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <p>Supplier</p>
                <select name="Supplier_id" required>
                    <option value="">-- Select Supplier --</option>
                    <?php foreach ($suppliers as $sup): ?>
                        <option value="<?= $sup['Supplier_id'] ?>"><?= htmlspecialchars($sup['Supplier_name']) ?></option>
                    <?php endforeach; ?>
                </select>

                <p>Price</p>
                <input type="number" step="0.01" name="Price" required>

                <label><br>Image:</label>
                <input type="file" name="image">

                <div class="btn-group">
                    <button type="submit" class="AddBtn">Add Product</button>
                    <button type="button" id="closeProductModal" class="CancelBtn">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Update Product Modal -->
        <div id="UpdateProductModal" class="modal-overlay">
            <form action="CRUD Functions/UpdateProduct.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="Product_id" id="updateProductId">
                <h1>Update Product</h1>
                <p>Product name</p>
                <input type="text" name="Product_name" id="updateProductName" required>

                <p>Category</p>
                <select name="Category_id" id="updateCategoryId" disabled>
                    <option value="">-- Select Category --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['Category_id'] ?>"><?= htmlspecialchars($cat['Category_name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="Category_id" id="hiddenCategoryId">

                <p>Price</p>
                <input type="number" step="0.01" name="Price" id="updatePrice" required>

                <div class="btn-group">
                    <button type="submit" class="UpdateBtn">Update Product</button>
                    <button type="button" id="closeUpdateProductModal" class="CancelBtn">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="modal-overlay" style="display:none;">
            <div class="modal-content">
                <h2>Confirm Deletion</h2>
                <p>Are you sure you want to delete <strong id="productName"></strong>?</p>
                <form id="deleteForm" action="delete_product.php" method="POST">
                    <input type="hidden" name="Product_id" id="deleteProductId">
                    <div class="btn-group">
                        <button type="submit" class="AddBtn">Yes, Delete</button>
                        <button type="button" id="cancelDelete" class="CancelBtn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script type="module" src="JS_Dashboard/Products.js"></script>
    <script type="module" src="JS_Dashboard/DashboardsTime.js"></script>
    <script type="module" src="JS_Dashboard/buttontransition.js"></script>
    <script type="module" src="JS_Dashboard/AddProductModal.js"></script>
    <script type="module" src="JS_Dashboard/UpdateProductModal.js"></script>
    <script src="JS_Dashboard/DeleteProductModal.js"></script>

    </body>
    </html>
