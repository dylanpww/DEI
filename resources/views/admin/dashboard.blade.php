@extends('layouts.app')

@section('title', 'Admin Dashboard - Crave')

@section('content')
<div class="max-w-7xl mx-auto space-y-12 pb-12">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-extrabold text-gray-900">Admin Dashboard</h1>
        <div class="flex gap-4">
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 flex items-center gap-2">
                <ion-icon name="people" class="text-crave-teal text-xl"></ion-icon>
                <span class="font-bold text-gray-700">{{ $users->count() }} Users</span>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 flex items-center gap-2">
                <ion-icon name="star" class="text-crave-orange text-xl"></ion-icon>
                <span class="font-bold text-gray-700">{{ $reviews->count() }} Reviews</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Users Management Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">User & Seller Management</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold">ID</th>
                        <th class="px-6 py-4 font-semibold">User</th>
                        <th class="px-6 py-4 font-semibold">Role</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Warnings</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $user->user_ID }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $user->username }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->role === 'seller' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->status === 'active')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Active</span>
                            @elseif($user->status === 'blocked')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                    Blocked
                                    @if($user->blocked_until)
                                        <br><span class="text-[10px] font-normal">until {{ \Carbon\Carbon::parse($user->blocked_until)->format('M d') }}</span>
                                    @endif
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Banned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-1">
                                @for($i=0; $i<3; $i++)
                                    <div class="w-3 h-3 rounded-full {{ $i < $user->warning_count ? 'bg-red-500' : 'bg-gray-200' }}"></div>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4 flex gap-2 justify-end">
                            @if($user->status !== 'active')
                                <form action="{{ route('admin.users.unblock', $user->user_ID) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded text-sm font-semibold transition-colors">Restore</button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.warn', $user->user_ID) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-gray-900 rounded text-sm font-semibold transition-colors" title="Warn User">Warn</button>
                                </form>
                                <form action="{{ route('admin.users.block', $user->user_ID) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white rounded text-sm font-semibold transition-colors" title="Block for 7 days">Block</button>
                                </form>
                                <form action="{{ route('admin.users.ban', $user->user_ID) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-sm font-semibold transition-colors" onclick="return confirm('Permanently ban this user?')" title="Permanent Ban">Ban</button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.users.delete', $user->user_ID) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-gray-200 hover:bg-red-500 hover:text-white text-gray-600 rounded text-sm font-semibold transition-colors" onclick="return confirm('Delete user and all their data? This cannot be undone.')">
                                    <ion-icon name="trash" class="align-middle"></ion-icon>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->isEmpty())
            <div class="p-8 text-center text-gray-500">No users found.</div>
        @endif
    </div>

    <!-- Reviews Management Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-8">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="text-xl font-bold text-gray-800">Reviews Management</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold">Review ID</th>
                        <th class="px-6 py-4 font-semibold">Product</th>
                        <th class="px-6 py-4 font-semibold">User</th>
                        <th class="px-6 py-4 font-semibold">Rating</th>
                        <th class="px-6 py-4 font-semibold w-1/3">Comment</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($reviews as $review)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-500">#{{ $review->review_ID }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 truncate w-32" title="{{ $review->product->name ?? 'Deleted' }}">
                                {{ $review->product->name ?? 'Deleted Product' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $review->user->username ?? 'Deleted User' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex text-crave-orange">
                                @for($i=0; $i<$review->rating; $i++)
                                    <ion-icon name="star"></ion-icon>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 line-clamp-2" title="{{ $review->comment }}">
                            {{ $review->comment ?: '-' }}
                        </td>
                        <td class="px-6 py-4 flex gap-2 justify-end">
                            <button type="button" onclick="openEditModal({{ $review->review_ID }}, {{ $review->rating }}, '{{ addslashes($review->comment) }}')" class="px-3 py-1.5 bg-crave-teal hover:bg-crave-darkgreen text-white rounded text-sm font-semibold transition-colors">
                                Edit
                            </button>
                            <form action="{{ route('admin.reviews.delete', $review->review_ID) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-500 hover:text-white text-red-600 rounded text-sm font-semibold transition-colors" onclick="return confirm('Delete this review?')">
                                    <ion-icon name="trash" class="align-middle"></ion-icon>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($reviews->isEmpty())
            <div class="p-8 text-center text-gray-500">No reviews found.</div>
        @endif
    </div>
</div>

<!-- Edit Review Modal -->
<div id="editReviewModal" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 m-4 z-10 transform transition-all scale-95 opacity-0 duration-200" id="modalContent">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-xl font-bold text-gray-900">Edit Review</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><ion-icon name="close-outline" class="text-2xl"></ion-icon></button>
        </div>
        <form id="editReviewForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Rating</label>
                    <select name="rating" id="edit_rating" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 p-2.5 border bg-white" required>
                        <option value="5">5 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="2">2 Stars</option>
                        <option value="1">1 Star</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Comment</label>
                    <textarea name="comment" id="edit_comment" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 p-3 border" placeholder="Review comment..."></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-gray-600 font-semibold hover:bg-gray-100 rounded-xl transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-crave-green hover:bg-crave-darkgreen text-white font-bold rounded-xl transition-colors shadow-md">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openEditModal(reviewId, rating, comment) {
        const modal = document.getElementById('editReviewModal');
        const content = document.getElementById('modalContent');
        const form = document.getElementById('editReviewForm');
        
        // Populate data
        document.getElementById('edit_rating').value = rating;
        document.getElementById('edit_comment').value = comment || '';
        
        // Update form action URL dynamically
        form.action = `/admin/reviews/${reviewId}`;
        
        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Small delay for transition
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeEditModal() {
        const modal = document.getElementById('editReviewModal');
        const content = document.getElementById('modalContent');
        
        // Hide transition
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
</script>
@endpush
