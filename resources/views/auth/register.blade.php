<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Fakultas -->
        <div class="mt-4">
            <x-input-label for="faculty_id" :value="__('Fakultas')" />
            <select id="faculty_id" name="faculty_id"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required>
                <option value="">Pilih Fakultas</option>
                @foreach ($faculties as $faculty)
                    <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                        {{ $faculty->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('faculty_id')" class="mt-2" />
        </div>

        <!-- Program Studi -->
        <div class="mt-4">
            <x-input-label for="program_study_id" :value="__('Program Studi')" />
            <select id="program_study_id" name="program_study_id"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required>
                <option value="">Pilih Program Studi</option>
            </select>
            <x-input-error :messages="$errors->get('program_study_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Dynamic Program Study loading based on Faculty selection
        document.getElementById('faculty_id').addEventListener('change', async function() {
            const facultyId = this.value;
            const prodiSelect = document.getElementById('program_study_id');

            // Clear existing options
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';

            if (!facultyId) {
                return;
            }

            try {
                const response = await fetch(`/api/program-studies/${facultyId}`);
                const programStudies = await response.json();

                programStudies.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi.id;
                    option.textContent = prodi.name;
                    prodiSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading program studies:', error);
            }
        });
    </script>
</x-guest-layout>
