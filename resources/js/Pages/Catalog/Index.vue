<template>
    <div class="container my-8">
        <v-data-table
            density="comfortable"
            :items="[
                { id: 0, name: 'Roy Victor', age: 25 },
                { id: 1, name: 'John Ricky', age: 21 },
                { id: 2, name: 'Mathew', age: 30 },
                { id: 3, name: 'Melvin', age: 18 },
                { id: 4, name: 'Sophia Johnson', age: 27 },
                { id: 5, name: 'Liam Smith', age: 22 },
                { id: 6, name: 'Emma Brown', age: 29 },
                { id: 7, name: 'Olivia Jones', age: 19 },
                { id: 8, name: 'Noah Davis', age: 24 },
                { id: 9, name: 'Ava Martinez', age: 23 },
                { id: 10, name: 'Isabella Lopez', age: 26 },
                { id: 11, name: 'Mason Gonzalez', age: 20 },
                { id: 12, name: 'Ethan Hernandez', age: 28 },
                { id: 13, name: 'Logan Moore', age: 31 },
                { id: 14, name: 'Lucas Taylor', age: 22 },
                { id: 15, name: 'Mia Anderson', age: 25 },
                { id: 16, name: 'Charlotte Thomas', age: 24 },
                { id: 17, name: 'Amelia Jackson', age: 27 },
                { id: 18, name: 'Harper White', age: 23 },
                { id: 19, name: 'Evelyn Harris', age: 28 },
                { id: 20, name: 'Alexander Clark', age: 32 },
                { id: 21, name: 'Michael Lewis', age: 19 },
                { id: 22, name: 'Benjamin Walker', age: 21 },
                { id: 23, name: 'Elijah Hall', age: 24 },
                { id: 24, name: 'James Allen', age: 30 },
                { id: 25, name: 'William Young', age: 27 },
                { id: 26, name: 'Daniel King', age: 25 },
                { id: 27, name: 'Henry Wright', age: 28 },
                { id: 28, name: 'Jacob Scott', age: 22 },
                { id: 29, name: 'David Green', age: 29 },
                { id: 30, name: 'Sebastian Adams', age: 26 },
                { id: 31, name: 'Samuel Baker', age: 23 },
                { id: 32, name: 'Matthew Nelson', age: 31 },
                { id: 33, name: 'Joseph Carter', age: 18 },
                { id: 34, name: 'Jack Mitchell', age: 20 },
                { id: 35, name: 'Owen Perez', age: 24 },
                { id: 36, name: 'Wyatt Roberts', age: 27 },
                { id: 37, name: 'Gabriel Turner', age: 25 },
                { id: 38, name: 'Grayson Phillips', age: 22 },
                { id: 39, name: 'Dylan Campbell', age: 28 },
                { id: 40, name: 'Julian Parker', age: 23 },
                { id: 41, name: 'Levi Evans', age: 21 },
                { id: 42, name: 'Isaac Edwards', age: 29 },
                { id: 43, name: 'Anthony Collins', age: 26 },
                { id: 44, name: 'Nathan Stewart', age: 30 },
                { id: 45, name: 'Joshua Sanchez', age: 25 },
                { id: 46, name: 'Christopher Morris', age: 19 },
                { id: 47, name: 'Andrew Rogers', age: 18 },
                { id: 48, name: 'Thomas Reed', age: 32 },
                { id: 49, name: 'Charles Cook', age: 31 },
            ]"
            :headers="[
                { value: 'Users Namesss', key: 'user_name' },
                { value: 'Thy emails', key: 'email' },
            ]"
        ></v-data-table>
    </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
