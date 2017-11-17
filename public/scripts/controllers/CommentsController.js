app.controller("CommentsController", ['$scope', '$http', '$timeout', function ($scope, $http, $timeout) {
    // Pusher.logToConsole = true;
    var pusher = new Pusher('b97ad9c93b6c1252a940');
    $scope.showMessage = false;
    $scope.newCommentsCount = 0;

    angular.element(document).ready(function () {
        var channel = pusher.subscribe('comment' + $scope.itemId);
        channel.bind('comment-posted', function (userid) {
            if (userid != $scope.currentUserId) {
                $scope.$apply(function () {
                    $scope.showMessage = true;
                    $scope.newCommentsCount++;
                    $scope.message = 'There is/are ' + $scope.newCommentsCount + ' new comment(s). Click [here] to view.';
                });
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
        }, function error(response) {
            $scope.errors = response.data.errors;
        });
    };
}]);

