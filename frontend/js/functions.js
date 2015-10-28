var loggedIn = 0;

// check logged in status

var app = angular.module('App',['ngRoute'],function($routeProvider) {        
    $routeProvider
    .when('/',{templateUrl:'/frontend/views/home.html', controller:'homeController'})
    .when('/profile',{templateUrl:'/frontend/views/profile.html', controller:'profileController'})
    .when('/baseline',{templateUrl:'/frontend/views/baseline.html', controller:'baselineController'})
    .when('/wod',{templateUrl:'/frontend/views/wod.html', controller:'wodController'})
    .when('/login',{templateUrl:'/frontend/views/login.html', controller:'loginController'})
    .when('/about',{templateUrl:'/frontend/views/about.html', controller:'aboutController'})
    .when('/benchmark',{templateUrl:'/frontend/views/benchmark.html', controller:'benchmarkController'})
    .when('/completed',{templateUrl:'/frontend/views/completed.html', controller:'completedController'})
    .when('/converter',{templateUrl:'/frontend/views/converter.html', controller:'converterController'})
    .when('/custom',{templateUrl:'/frontend/views/custom.html', controller:'customController'})
    .when('/help',{templateUrl:'/frontend/views/help.html', controller:'helpController'})
    .when('/locator',{templateUrl:'/frontend/views/locator.html', controller:'locatorController'})
    .when('/logout',{templateUrl:'/frontend/views/logout.html', controller:'logoutController'})
    .when('/mygym',{templateUrl:'/frontend/views/mygym.html', controller:'mygymController'})
    .when('/personal',{templateUrl:'/frontend/views/personal.html', controller:'personalController'})
    .when('/progress',{templateUrl:'/frontend/views/progress.html', controller:'progressController'})
    .when('/skills',{templateUrl:'/frontend/views/skills.html', controller:'skillsController'})
    .when('/subscribe',{templateUrl:'/frontend/views/subscribe.html', controller:'subscribeController'})
    .when('/terms',{templateUrl:'/frontend/views/terms.html', controller:'termsController'})
    .when('/videos',{templateUrl:'/frontend/views/videos.html', controller:'videosController'})
    .when('/signup',{templateUrl:'/frontend/views/signup.html', controller:'signupController'})
    .when('/contact',{templateUrl:'/frontend/views/contact.html', controller:'contactController'})
    .when('/converter_height',{templateUrl:'/frontend/views/converter_height.html', controller:'cHeightController'})
    .when('/converter_weight',{templateUrl:'/frontend/views/converter_weight.html', controller:'cWeightController'})
    .when('/converter_distance',{templateUrl:'/frontend/views/converter_distance.html', controller:'cDistanceController'})
    .otherwise({redirectTo:'/'});
});

app.factory('Loading', function($http) {
    return {
        listeners: [],
        init: function() {
            $http.post('/api/members/memberstatus', {msg:'Checking User Status'}).
            success(function(data, status, headers, config) {
                if(data.type == 'failed')
                {
                    document.location.hash = 'login';
                }
            }).
            error(function(data, status, headers, config) {

            });
        }
    };
});

app.controller('homeController', function($scope, $http) {
    // Simple POST request example (passing data) :
    $http.post('/api/members/memberstatus', {msg:'Checking User Status'}).
    success(function(data, status, headers, config) {
        if(data.type == 'failed')
            document.location.hash = 'login';
        else
        {
            $http.post('/api/members/checksubscription', {msg:'Checking User Subscription'}).
            success(function(data, status, headers, config) {
                $scope.subscription = data.content;
            }).
            error(function(data, status, headers, config) {

            });
        }
    }).
    error(function(data, status, headers, config) {

    });

});

app.controller('signupController', function($scope, $http) {
    $scope.register = function(user) {
        if(user)
        {
            $http.post('/api/members/signup/', { data: user }).
            success(function(data, status, headers, config) {
                if(data.type == 'failed')
                    document.location.hash = 'signup';
                else
                    document.location.hash = 'home';
            }).
            error(function(data, status, headers, config) {

            });

            alert(user.name)
        }
        else
        {
            alert('User entered nothing')
        }
    };
});

app.controller('cHeightController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('cWeightController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('cDistanceController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('baselineController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('wodController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('loginController', function($scope, $http) {
    // Simple POST request example (passing data) :
    $scope.login = function(user) {
        if(user)
        {
            $http.post('/api/members/login/', { username:user.name, password:user.password, remember:user.remember }).
            success(function(data, status, headers, config) {
                if(data.type == 'failed')
                {
                    if(data.text == 'user_not_verified' || data.text == 'user_details_not_found')
                        $scope.message = data.data;
                }
                else
                {
                    if(data.type == 'success')
                    {
                        if(data.location)
                        {
                            document.location.hash = 'home';
                        }
                    }
                }
            }).
            error(function(data, status, headers, config) {

            });
        }
        else
        {
            $scope.message = 'Please make sure you have filled in your login details.';
        }
    };
});

app.controller('aboutController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('benchmarkController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('completedController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('converterController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('customController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('helpController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('locatorController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('logoutController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('mygymController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('personalController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('progressController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('skillsController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('subscribeController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('termsController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});

app.controller('videosController', function($scope, $http) {
    // Simple POST request example (passing data) :
    
});




app.controller('profileController', function($scope, $http) {
    $http.post('/api/members/memberstatus', {msg:'Checking User Status'}).
    success(function(data, status, headers, config) {
        if(data.type == 'failed')
        {
            document.location.hash = 'login';
        }
        else
        {
            $http.post('/api/members/profile', {msg:'Get user data'}).
            success(function(data, status, headers, config) {
                if(data.type == 'success')
                {
                    $scope.name = data.data['FirstName'];
                    $scope.surname = data.data['LastName'];
                    $scope.cellphone = data.data['Cell'];
                    $scope.email = data.data['Email'];
                    $scope.username = data.data['UserName'];
                }
            }).
            error(function(data, status, headers, config) {

            });
        }
    }).
    error(function(data, status, headers, config) {

    });
});


app.controller("slideMenu", function($scope, $rootScope, $http) {
	$scope.leftVisible = false;
    $scope.rightVisible = false;

    $http.post('/api/members/profile', {msg:'Get user data'}).
    success(function(data, status, headers, config) {
        if(data.type == 'success')
            $scope.menu_username = data.data['UserName'];
    }).
    error(function(data, status, headers, config) {

    });

    $scope.close = function() {
        $scope.leftVisible = false;
        $scope.rightVisible = false;
    };

    $scope.showLeft = function(e) {
        $scope.leftVisible = true;
        e.stopPropagation();
    };
    
    $scope.showRight = function(e) {
        $scope.rightVisible = true;
        e.stopPropagation();
    }
    
    $rootScope.$on("documentClicked", _close);
    $rootScope.$on("escapePressed", _close);
    
    function _close() {
        $scope.$apply(function() {
            $scope.close(); 
        });
    }
});

app.run(function($rootScope, Loading) {

    Loading.init();

    document.addEventListener("keyup", function(e) {
      if (e.keyCode === 27)
         $rootScope.$broadcast("escapePressed", e.target);
 });
    
    document.addEventListener("click", function(e) {
        $rootScope.$broadcast("documentClicked", e.target);
    });
});

app.directive("menu", function() {
	return {
		restrict: "E",
		template: "<div ng-class='{ show: visible, left: alignment === \"left\", right: alignment === \"right\" }' ng-transclude></div>",
		transclude: true,
        scope: {
            visible: "=",
            alignment: "@"
        }
    };
});

app.directive("menuHeading", function() {
	return {
		restrict: "E",
		template: "<div ng-class='{ show: visible, left: alignment === \"left\", right: alignment === \"right\" }' ng-transclude></div>",
		transclude: true,
        scope: {
            visible: "=",
            alignment: "@"
        }
    };
});

app.directive("menuItem", function() {
   return {
       restrict: "E",
       template: "<div ng-click='navigate()' ng-transclude></div>",
       transclude: true,
       scope: {
           hash: "@"
       },
       link: function($scope) {
           $scope.navigate = function() {
               window.location.hash = $scope.hash;
           }
       }
   }
});