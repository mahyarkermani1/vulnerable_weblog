

<div class="login-wrapper">
    <div class="container">
        <h2>Write a Blog Post</h2>
        <form action="./save_post.php" method="POST">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" required rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category">
                
                    <?php foreach($data_category as $row) {
                            echo "<option value='$row[0]'>$row[1]</option>";};
                    ?>
                </select>
            </div>
            <div class="button-group">
                <button type="submit">Post</button>
                <button type="button" onclick="document.getElementById('title').value=''; document.getElementById('content').value=''; document.getElementById('category').selectedIndex = 0;">Clear</button>
            </div>
        </form>
    </div>
</div>
