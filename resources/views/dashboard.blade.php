 <style>
     .dashboard-container {
         display: flex;
         height: 88vh;
         overflow: hidden;
         background: #f8fafc;
     }
 </style>
 <x-app-layout>
     <div class="dashboard-container">
         <livewire:layout.mobile-header />
         <x-sidebar />
         <livewire:posts />
     </div>
 </x-app-layout>