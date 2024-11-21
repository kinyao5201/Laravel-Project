<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleandUserController extends Controller
{
    public function index()
    {
        $users = User::role(['admin', 'user'])->paginate(10);

        return view('admin.roles.index', compact('users'));
    }

    public function create(Request $request)
    {
        // 獲取未分配角色的用戶
        $users = User::whereDoesntHave('roles')->paginate(10);

        // 獲取要分配的角色類型（admin 或 user）
        $type = $request->query('type');

        return view('admin.roles.create', compact('users', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'role_type' => 'required|in:admin,user',
        ]);

        // 获取选中的用户
        $users = User::whereIn('id', $request->user_ids)->get();

        // 为每个用户分配角色
        foreach ($users as $user) {
            $user->assignRole($request->role_type);
        }

        // 返回成功消息和重定向
        return redirect()->route('admin.roles.index')->with('success', '角色分配成功');
    }

    // 更新角色的方法
    public function update(Request $request, $role)
    {
        // 驗證選中的角色
        $request->validate([
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'exists:users,id', // 確保用戶 ID 存在
        ]);

        // 迭代選中的用戶 ID 並解除角色
        $users = User::whereIn('id', $request->selected_ids)->get();
        foreach ($users as $user) {
            // 檢查用戶是否有這個角色，並移除該角色
            if ($user->hasRole($role)) {
                $user->removeRole($role); // 移除角色
            }
        }

        // 成功後重定向並顯示訊息
        return redirect()->route('admin.roles.index')->with('success', '角色已成功移除');
    }
}