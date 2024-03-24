<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-container>
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
          <home/>
        </div>
                </v-container>
                <router-view></router-view>
            </v-main>
        </v-app>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>