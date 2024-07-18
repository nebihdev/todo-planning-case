<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto sm:px-6 lg:px-8 my-10">
    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">To-Do Planning</h1>
                        <p class="mt-2 text-sm text-gray-700">Aşağıda Tasklerin sprint bazında hangi developerlara atandığını görebilirsiniz.</p>
                        <h3 class="text-base font-semibold leading-6 text-gray-900 mt-10">Tüm tasklerin bitmesi için gereken sprint sayısı: {{ $sprints->count() }}</h3>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full">
                                <thead class="bg-white">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">Task Adı</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Atanan Developer</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Zorluk</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Developer Eforu (Saat)</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white">
                                @foreach($sprints as $sprint)
                                    <tr class="border-t border-gray-200">
                                        <th colspan="3" scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left font-semibold text-sm text-gray-900 sm:pl-3">{{ $sprint->name }}</th>
                                        <th colspan="1" scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left font-semibold text-sm text-gray-900 sm:pl-3">Toplam Efor (Saat): {{ $sprint->takenHoursToFinishTasks }}</th>
                                    </tr>
                                    @foreach($sprint->tasks as $task)
                                        <tr class="border-t border-gray-300">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">{{ $task->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->assignedDeveloper->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $task->difficulty_level }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->estimated_duration_for_assigned_developer }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
