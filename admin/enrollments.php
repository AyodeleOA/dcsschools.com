<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';
require_admin();
$pdo = db();

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare('DELETE FROM enrollments WHERE id = ?')->execute([$id]);
    set_flash('Enrollment record deleted');
    redirect_to('dcsschools.com/admin/enrollments.php');
}

$items = $pdo->query('SELECT * FROM enrollments ORDER BY created_at DESC, id DESC')->fetchAll();
$page_title = 'Enrollments';
ob_start();
?>
<section class="panel">
    <h2>Enrollment Applications</h2>
    <div class="list table-list">
        <?php if (empty($items)): ?>
            <div class="row">
                <div class="cell">No enrollments found yet.</div>
            </div>
        <?php else: ?>
            <div class="row header-row">
                <div class="cell">Date</div>
                <div class="cell">Student</div>
                <div class="cell">Class</div>
                <div class="cell">Parent</div>
                <div class="cell">Contact</div>
                <div class="cell">Actions</div>
            </div>
            <?php foreach ($items as $m): ?>
                <div class="row">
                    <div class="cell"><?php echo date('M j, Y', strtotime($m['created_at'])); ?></div>
                    <div class="cell">
                        <strong><?php echo htmlspecialchars($m['student_name']); ?></strong><br>
                        <small class="text-muted"><?php echo htmlspecialchars($m['gender']); ?>, <?php echo htmlspecialchars($m['dob']); ?></small>
                    </div>
                    <div class="cell"><?php echo htmlspecialchars($m['intended_class']); ?></div>
                    <div class="cell">
                        <strong><?php echo htmlspecialchars($m['parent_name']); ?></strong><br>
                        <small class="text-muted"><?php echo htmlspecialchars($m['relationship']); ?></small>
                    </div>
                    <div class="cell contact-info">
                        <a href="tel:<?php echo htmlspecialchars($m['phone']); ?>"><?php echo htmlspecialchars($m['phone']); ?></a>
                        <a href="mailto:<?php echo htmlspecialchars($m['email']); ?>"><?php echo htmlspecialchars($m['email']); ?></a>
                    </div>
                    <div class="cell actions">
                        <button class="btn btn-sm btn-view" data-modal="view-modal" 
                            data-student="<?php echo htmlspecialchars($m['student_name']); ?>"
                            data-gender="<?php echo htmlspecialchars($m['gender']); ?>"
                            data-dob="<?php echo htmlspecialchars($m['dob']); ?>"
                            data-class="<?php echo htmlspecialchars($m['intended_class']); ?>"
                            data-parent="<?php echo htmlspecialchars($m['parent_name']); ?>"
                            data-relationship="<?php echo htmlspecialchars($m['relationship']); ?>"
                            data-phone="<?php echo htmlspecialchars($m['phone']); ?>"
                            data-email="<?php echo htmlspecialchars($m['email']); ?>"
                            data-address="<?php echo htmlspecialchars($m['address']); ?>"
                            data-date="<?php echo htmlspecialchars($m['created_at']); ?>"
                        >View</button>
                        <a class="btn btn-sm btn-danger" href="https://dcsschools.com/admin/enrollments.php?delete=<?php echo $m['id']; ?>" onclick="return confirm('Are you sure you want to delete this enrollment?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<style>
    .table-list {
        display: flex;
        flex-direction: column;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }
    .row {
        display: grid;
        grid-template-columns: 100px 1.5fr 100px 1.5fr 1.5fr 140px;
        gap: 15px;
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        align-items: center;
        background: #fff;
    }
    .row:last-child {
        border-bottom: none;
    }
    .row.header-row {
        background: #f8fafc;
        font-weight: 600;
        color: #475569;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .cell {
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 0.95rem;
        color: #334155;
    }
    .cell small {
        font-size: 0.85rem;
        color: #64748b;
    }
    .contact-info a {
        display: block;
        color: #2563eb;
        text-decoration: none;
        font-size: 0.9rem;
    }
    .contact-info a:hover {
        text-decoration: underline;
    }
    .actions {
        display: flex;
        gap: 8px;
    }
    .btn-sm {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        border: none;
    }
    .btn-view {
        background: #eff6ff;
        color: #1d4ed8;
    }
    .btn-view:hover {
        background: #dbeafe;
    }
    .btn-danger {
        background: #fef2f2;
        color: #dc2626;
    }
    .btn-danger:hover {
        background: #fee2e2;
    }
    @media (max-width: 1024px) {
        .row {
            grid-template-columns: 1fr;
            gap: 10px;
            padding: 15px;
            height: auto;
        }
        .row.header-row {
            display: none;
        }
        .cell {
            display: flex;
            flex-direction: column;
        }
        .cell::before {
            content: attr(data-label);
            font-weight: 600;
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
    }
</style>

<!-- View Modal -->
<div id="view-modal" class="modal" style="display:none; width: min(800px, 90vw);">
    <header>
        <h3>Enrollment Details</h3>
        <button class="modal-close" style="background:none; color:#000; font-size:24px; padding:0;">&times;</button>
    </header>
    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label>Date Applied</label>
                <input type="text" data-fill="date" readonly>
            </div>
            <div class="form-group">
                <label>Student Name</label>
                <input type="text" data-fill="student" readonly>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <input type="text" data-fill="gender" readonly>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="text" data-fill="dob" readonly>
            </div>
            <div class="form-group">
                <label>Intended Class</label>
                <input type="text" data-fill="class" readonly>
            </div>
            <div class="form-group">
                <label>Parent Name</label>
                <input type="text" data-fill="parent" readonly>
            </div>
            <div class="form-group">
                <label>Relationship</label>
                <input type="text" data-fill="relationship" readonly>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" data-fill="phone" readonly>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" data-fill="email" readonly>
            </div>
            <div class="form-group" style="grid-column: span 2;">
                <label>Address</label>
                <textarea data-fill="address" readonly rows="3" style="width: 100%;"></textarea>
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>
