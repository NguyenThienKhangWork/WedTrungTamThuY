<?php
/**
 * PawNest & CozyPaws - Domain Model: User
 * Đại diện cho người dùng hệ thống (Nhân viên quản trị Admin, Lễ tân Receptionist)
 */

declare(strict_types=1);

class User {
    public ?int $id;
    public string $username;
    public string $fullName;
    public string $email;
    public string $role;
    public bool $isActive;

    public function __construct(array $data = []) {
        $this->id       = isset($data['id']) ? (int)$data['id'] : null;
        $this->username = trim($data['username'] ?? '');
        $this->fullName = trim($data['full_name'] ?? '');
        $this->email    = trim($data['email'] ?? '');
        $this->role     = $data['role'] ?? 'staff';
        $this->isActive = !empty($data['is_active']);
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isReceptionist(): bool {
        return in_array($this->role, ['receptionist', 'staff', 'letan'], true);
    }

    public function canManageInventory(): bool {
        return $this->isAdmin() || $this->role === 'veterinarian';
    }
}
