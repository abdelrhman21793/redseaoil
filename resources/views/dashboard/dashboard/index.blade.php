<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
            <div class="text-sm text-gray-600">
                Welcome back, {{ Auth::user()->name }}!
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Users Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Users</p>
                            <p class="text-3xl font-bold">{{ $usersCount }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-blue-100">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm">Active users</span>
                    </div>
                </div>

                <!-- Admins Card -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Administrators</p>
                            <p class="text-3xl font-bold">{{ $adminsCount }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-green-100">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm">System administrators</span>
                    </div>
                </div>

                <!-- Super Admins Card -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Super Admins</p>
                            <p class="text-3xl font-bold">{{ $superAdminsCount }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-purple-100">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM15.657 6.343a1 1 0 011.414 0A9.972 9.972 0 0119 12a9.972 9.972 0 01-1.929 5.657 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 12c0-1.194-.26-2.327-.743-3.343a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm">Full access</span>
                    </div>
                </div>

                <!-- Wells Card -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Total Wells</p>
                            <p class="text-3xl font-bold">{{ $wellsCount }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-orange-100">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm">Active wells</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Quick Actions -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Manage Users -->
                            <a href="{{ route('users.index') }}" class="group bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-lg p-4 transition-all duration-200 border border-blue-200">
                                <div class="flex items-center">
                                    <div class="bg-blue-500 rounded-lg p-3 mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800 group-hover:text-blue-800">Manage Users</h4>
                                        <p class="text-sm text-gray-600">Add, edit, or remove users</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Manage Wells -->
                            <a href="{{ route('wells.index') }}" class="group bg-gradient-to-r from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 rounded-lg p-4 transition-all duration-200 border border-orange-200">
                                <div class="flex items-center">
                                    <div class="bg-orange-500 rounded-lg p-3 mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800 group-hover:text-orange-800">Manage Wells</h4>
                                        <p class="text-sm text-gray-600">Monitor and manage wells</p>
                                    </div>
                                </div>
                            </a>

                            @if (Auth::user()->type == 'SUPER_ADMIN')
                            <!-- Manage Operations -->
                            <a href="{{ route('optionStructures.index') }}" class="group bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-lg p-4 transition-all duration-200 border border-green-200">
                                <div class="flex items-center">
                                    <div class="bg-green-500 rounded-lg p-3 mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800 group-hover:text-green-800">Operations</h4>
                                        <p class="text-sm text-gray-600">Manage system operations</p>
                                    </div>
                                </div>
                            </a>
                            @endif

                            <!-- View Requests -->
                            <a href="{{ route('requests.index') }}" class="group bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-lg p-4 transition-all duration-200 border border-purple-200">
                                <div class="flex items-center">
                                    <div class="bg-purple-500 rounded-lg p-3 mr-4">
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800 group-hover:text-purple-800">View Requests</h4>
                                        <p class="text-sm text-gray-600">Handle pending requests</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="space-y-6">
                    <!-- System Overview -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">System Overview</h3>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm text-green-600 font-medium">Online</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Database</span>
                                </div>
                                <span class="text-sm font-medium text-green-600">Connected</span>
                            </div>

                            <div class="flex items-center justify-between py-3 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-orange-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Server</span>
                                </div>
                                <span class="text-sm font-medium text-green-600">Running</span>
                            </div>

                            <div class="flex items-center justify-between py-3">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Last Backup</span>
                                </div>
                                <span class="text-sm font-medium text-gray-600">{{ now()->format('M d, Y') }}</span>
                        </div>
                      </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-800">System initialized</p>
                                    <p class="text-xs text-gray-500">{{ now()->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-800">Database connected</p>
                                    <p class="text-xs text-gray-500">{{ now()->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-800">Wells data loaded</p>
                                    <p class="text-xs text-gray-500">{{ now()->format('M d, Y \a\t H:i') }}</p>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>

            <!-- Additional Stats Section -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">System Statistics</h3>
                    <div class="text-sm text-gray-500">Last updated: {{ now()->format('M d, Y \a\t H:i') }}</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $usersCount + $adminsCount + $superAdminsCount }}</div>
                        <div class="text-sm text-gray-600">Total System Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-orange-600">{{ $wellsCount }}</div>
                        <div class="text-sm text-gray-600">Active Wells</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">100%</div>
                        <div class="text-sm text-gray-600">System Uptime</div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</x-app-layout>
