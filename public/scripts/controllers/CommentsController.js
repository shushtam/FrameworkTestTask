app.controller("CommentsController", ['$scope', '$http', '$timeout', function ($scope, $http, $timeout) {
    // Pusher.logToConsole = true;
    var pusher = new Pusher('b97ad9c93b6c1252a940');
    $scope.showMessage = false;
    $scope.newCommentsCount = 0;
    $scope.typingUsers = [];

    angular.element(document).ready(function () {
        var channel = pusher.subscribe('comment' + $scope.itemId);
        var typingChannel = pusher.subscribe('typing' + $scope.itemId);
        channel.bind('comment-posted', function (userid) {
            if (userid != $scope.currentUserId) {
                $scope.$apply(function () {
                    $scope.showMessage = true;
                    $scope.newCommentsCount++;
                    $scope.message = 'There is/are ' + $scope.newCommentsCount + ' new comment(s). Click [here] to view.';
                });
            }


        });
        typingChannel.bind('typing-comment', function (data) {
            if (data.typing) {
                var exists = false;
                for (var i = 0; i < $scope.typingUsers.length; i++) {
                    if ($scope.typingUsers[i].userid == data.userid) {
                        exists = true;
                    }
                }
                if (!exists && data.userid != $scope.currentUserId) {
                    $scope.$apply(function () {
                        $scope.typingUsers.push({userid: data.userid, username: data.username});
                    });
                }
            }
            else {
                for (var i = 0; i < $scope.typingUsers.length; i++) {
                    if ($scope.typingUsers[i].userid == data.userid) {
                        $scope.$apply(function () {
                            $scope.typingUsers.splice(i, 1);
                        });
                    }
                }
            }

        });
    });
    $scope.postComment = function () {
        $http({
            method: "POST",
            url: "/store",
            data: {item_id: $scope.itemId, comment: $scope.comment}
        }).then(function success(response) {
            $scope.comment = "";
            $scope.comments = response.data;
            if ($scope.showMessage) {
                $scope.showMessage = false;
                $scope.newCommentsCount = 0;
            }
            $scope.typingEvent(false);
        }, function error(response) {
            $scope.errors = response.data.errors;
        });
    };
    $scope.getNewComments = function () {
        $scope.showMessage = false;
        $scope.newCommentsCount = 0;
        $scope.lastElement = $scope.comments.length;
        $http({
            method: "GET",
            url: "/get",
            params: {id: $scope.itemId}
        }).then(function success(response) {
            $scope.comments = response.data;
            $timeout(function () {
                angular.element('html, body').animate({
                    scrollTop: $("[data-id='" + $scope.lastElement + "']").offset().top
                }, 2000);
            })

        }, function error(response) {
        });
    };

    $scope.typingComment = function () {
        var typing = false;
        if ($scope.comment) {
            typing = true;
        }
        $scope.typingEvent(typing);


    };
    $scope.typingEvent = function (typing) {
        $http({
            method: "GET",
            url: "/typing",
            params: {item_id: $scope.itemId, typing: typing}
        }).then(function success(response) {
        }, function error(response) {
        });
    };
}]);

