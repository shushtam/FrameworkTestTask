@extends('layouts.app')

@section('content')
    <div class="container" ng-app="testApp" ng-controller="CommentsController">
        <div class="row" ng-init="itemId={{ json_encode($item_id) }}">
            @if (Auth::guest())
                <span class="no-display" ng-init="currentUserId=''"></span>
            @else
                <span class="no-display" ng-init="currentUserId={{ json_encode(Auth::user()->id) }}"></span>
            @endif
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-danger new-comments-container no-display" ng-show="showMessage"
                     ng-class="showMessage?'block-display':''">
                    There is/are <% newCommentsCount %> new comment(s). Click
                    <a class="new-comments-link" ng-click="getNewComments()">[here]</a> to view.
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Comments</div>
                    <div class="panel-body" ng-init="comments={{ json_encode($comments) }} ">
                        <div ng-repeat="comment in comments track by $index">
                            <p data-id="<% $index %>" ng-bind-html="comment.description"></p>
                            <hr>
                        </div>
                        <div ng-if="comments.length==0">
                            There are no comments about this item.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">New Comment</div>
                    <div class="panel-body">
                        <div class="col-md-12 typing-users-container no-display" ng-show="typingUsers.length>0"
                             ng-class="typingUsers?'block-display':''">
                            <p ng-repeat="user in typingUsers">
                                <% user.username %> is typing a response...
                            </p>
                        </div>
                        <br/>
                        <form class="form-horizontal" ng-submit="postComment()">
                            {{ csrf_field() }}
                            <div class="form-group" ng-class="errors? 'has-error':''">
                                <label for="comment" class="col-md-5 comment-label">Your Comment</label>
                                <div class="col-md-12">
                                    <div id="comment" class="form-control comment-container" ng-model="comment"
                                         ng-change="typingComment()"
                                         text-angular data-ta-toolbar="[  ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'pre', 'quote'],
                                                                          ['bold', 'italics', 'underline', 'strikeThrough', 'ul', 'ol', 'redo', 'undo', 'clear'],
                                                                          ['justifyLeft', 'justifyCenter', 'justifyRight', 'indent', 'outdent'],
                                                                          ['html','insertLink', 'wordcount', 'charcount']]">
                                    </div>
                                    <span ng-if="errors.comment.length>0" class="help-block">
                                      <p ng-repeat="error in errors.comment">
                                          <strong><% error %></strong>
                                      </p>
                                    </span>
                                    <span ng-if="errors.auth.length>0" class="help-block">
                                      <p ng-repeat="error in errors.auth">
                                          <strong><% error %></strong>
                                      </p>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2 col-md-offset-5">
                                    <button type="submit" class="btn btn-primary">
                                        Post
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection