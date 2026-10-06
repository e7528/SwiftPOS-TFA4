<div class="mb-4">
    <h2 class="fw-bold text-dark mb-1">About SwiftPOS</h2>
    <p class="text-secondary">Architectural specification and design documentation for Web System Technologies. Created with Gemini, managed and reviewed by A.C. Tan </p>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 rounded-3 mb-4">
            <h4 class="fw-bold text-dark mb-3">Project Scope</h4>
            <p class="text-secondary lh-lg mb-0">
                SwiftPOS is a database-backed web application illustrating the <strong>Model-View-Controller (MVC)</strong> architectural pattern implemented with <strong>CodeIgniter 4</strong>. In Phase 2, models and Query Builder retrieve persistent customer and user records from MySQL for controllers to pass safely to the views.
            </p>
        </div>

        <div class="card border-0 shadow-sm p-4 rounded-3">
            <h4 class="fw-bold text-dark mb-3">MVC Pipeline Workflow</h4>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="text-primary fw-bold mb-1"><i class="bi bi-signpost-split me-1"></i> 1. Route</div>
                        <small class="text-muted"><code>app/Config/Routes.php</code> maps GET and POST requests; an authentication filter protects account routes.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="text-info fw-bold mb-1"><i class="bi bi-cpu me-1"></i> 2. Controller</div>
                        <small class="text-muted">Requests records through CodeIgniter models, organizes view payloads, and initiates composite views.</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="text-success fw-bold mb-1"><i class="bi bi-window-sidebar me-1"></i> 3. View</div>
                        <small class="text-muted">Iterates over database result sets using <code>foreach</code> blocks and escapes output safely via <code>esc()</code>.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4 rounded-3">
            <h5 class="fw-bold text-dark mb-3">Environment Specs</h5>
            <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">Framework</span>
                    <span class="fw-semibold">CodeIgniter 4</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">CSS Framework</span>
                    <span class="fw-semibold">Bootstrap 5.3.3</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">Icon Library</span>
                    <span class="fw-semibold">Bootstrap Icons 1.11</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">Data Source</span>
                    <span class="badge bg-success-subtle text-success">MySQL Database</span>
                </li>
                <li class="list-group-item d-flex justify-content-between px-0 py-2">
                    <span class="text-muted">App Environment</span>
                    <span class="badge bg-warning-subtle text-warning-emphasis">Development</span>
                </li>
            </ul>
        </div>
    </div>
</div>
