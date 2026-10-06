</main>

<footer class="bg-white border-top py-3 mt-auto text-muted">
    <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
        <small class="fw-medium">&copy; <?= esc(date('Y')) ?> <strong>SwiftPOS</strong> &bull; Point-of-Sale System</small>
        <div class="d-flex align-items-center gap-2">
            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">
                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Phase 4 Authentication
            </span>
            <small class="text-secondary">CodeIgniter <?= esc(CodeIgniter\CodeIgniter::CI_VERSION) ?></small>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
