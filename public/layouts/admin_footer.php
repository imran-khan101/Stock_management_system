</main>

<footer class="footer">
    <div class="container">
        <span class="text-muted">Copyright <?php echo date("Y", time()); ?>, Imran Khan</span>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>-->


<script src="../js/jquery-ui.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/popper.min.js"></script>
</body>
</html>

<?php if (isset($database)) {
    $database->close_connection();
} ?>