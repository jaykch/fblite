//------ LOGIN DETAILS -----//
// FORMAT:: username : password
// user1 : testing11
// user2 : testing11
// user3 : testing11
// user4 : testing11


//------ REGISTER USER -----//

// Dob fields are pulled from the website form and stored as a date type variable using javascript Date() function
let dob = new Date(1992, 11, 30);

// All details are pulled from the website form
let username = "user";
user = {
    "username": username,
    "name": username,
    "email": username + "@testing.com",
    "password": "testing11",
    "dateOfBirth": dob,
    "gender": "Female",
    "location": "Melbourne",
    "relationshipStatus": "Single",
    "visibilityStatus": NumberInt(1),
    "friends": [],
    "friendRequests": [],
};

// Once the details are stored they are pushed tot the database and stored in a cookie to access inside the site
// (In php it was done in the session variables but in javascript we use localstorage/cookies)
try {
    db.Users.insertOne(user);
} catch (e) {
    print(e);
}

//------ LOGIN USER -----//
let loggedInUser = db.Users.findOne({username: "user1", password: 'testing11'});
// Code to check if logged in or unsuccessful
loggedInUser != null ? print("Logged in successfully!") : print("Wrong username or password");

//------ UPDATE USER -----//
db.Users.update({_id: loggedInUser._id}, {
    $set: {
        username: 'updatedUser',
        location: 'Sydney',
        relationshipStatus: 'Married',
        visibilityStatus: NumberInt(3)
    }
});

//------ DELETE USER -----//
db.Users.deleteOne({_id: loggedInUser._id}, function (err, obj) {
    if (err) throw err;
    console.log("1 document deleted");
});

//------ CREATE POST -----//
let post = {
    user: loggedInUser._id,
    timestamp: new Timestamp(),
    body: loggedInUser.username + "'s fourth post",
    likes: [],
    comments: []
};

db.Posts.insertOne(post);

//------ SHOW OWN POSTS -----//
db.Users.aggregate([
    {$match: {_id: loggedInUser._id}},
    {
        $lookup: {
            from: 'Posts',
            localField: '_id',
            foreignField: 'user',
            as: 'ownPosts'
        }
    },
    {
        $group: {
            _id: "$_id",
            posts: {$push: '$ownPosts.body'},
        }
    }
]);

//------ SHOW FRIENDS POSTS -----//
db.Users.aggregate([
    {$match: {_id: {$in: loggedInUser.friends}}},
    {
        $lookup: {
            from: 'Posts',
            localField: '_id',
            foreignField: 'user',
            as: 'friendsPosts'
        }
    },
    {
        $group: {
            _id: "$_id",
            posts: {$push: '$friendsPosts.body'},
        }
    }
]);

//------ SHOW SPECIFIC FRIENDS POST -----//

let friendPostIndex = 0;

db.Users.aggregate([
    {$match: {_id: loggedInUser.friends[friendPostIndex]}},
    {
        $lookup: {
            from: 'Posts',
            localField: '_id',
            foreignField: 'user',
            as: 'friendsPosts'
        }
    },
    {
        $group: {
            _id: "$_id",
            posts: {$push: '$friendsPosts.body'},
        }
    }
]);

//------ LIKE FRIENDS POST -----//

// First you look up a specific friends post (or of any user but in this case we are using a friend's post)
// In an app this post would be showing on the dashboard and would have it's _id attached to it
const r = db.Users.aggregate([
    {$match: {_id: loggedInUser.friends[0]}},
    {
        $lookup: {
            from: 'Posts',
            localField: '_id',
            foreignField: 'user',
            as: 'posts'
        }
    }
]);

// Then you save its ID
const friendsPostId = r.toArray()[0]['posts'][0]._id;

// For testing purposes this is how you can view the particular post
// let friendsPost = db.Posts.findOne({_id: friendsPostId});

// Then you push a like as the current logged in user
db.Posts.update({_id: friendsPostId}, {
    $push: {
        likes: loggedInUser._id
    }
});

//------ CREATE COMMENT -----//

// First you look up a specific friends post (or of any user but in this case we are using a friend's post)
// In an app this post would be showing on the dashboard and would have it's _id attached to it
const commentTest = db.Users.aggregate([
    {$match: {_id: loggedInUser.friends[0]}},
    {
        $lookup: {
            from: 'Posts',
            localField: '_id',
            foreignField: 'user',
            as: 'posts'
        }
    }
]);

// Then you save its ID
const commentTestId = commentTest.toArray()[0]['posts'][1]._id;

// Define new comment
let commentTestObject = {
    user: loggedInUser._id,
    timestamp: new Timestamp(),
    body: loggedInUser.username + "'s first comment on friends post",
    likes: [],
    replies: []
};

// Push it into the friend's post with the current timestamp and the poster of comment will be the logged in user
db.Posts.update({_id: commentTestId}, {
    $push: {
        comments: commentTestObject
    }
});

//------ CREATE REPLY -----//

// First you look up a specific friends post (or of any user but in this case we are using a friend's post)
// In an app this post would be showing on the dashboard and would have it's _id attached to it
const replyTestPost = db.Users.aggregate([
    {$match: {_id: loggedInUser.friends[0]}},
    {
        $lookup: {
            from: 'Posts',
            localField: '_id',
            foreignField: 'user',
            as: 'posts'
        }
    }
]);

// Then you save its ID
const replyTestPostId = replyTestPost.toArray()[0]['posts'][1]._id;

// Define new reply
let replyTestObject = {
    user: loggedInUser._id,
    timestamp: new Timestamp(),
    body: loggedInUser.username + "'s second reply on a comment with an index",
    likes: [],
    replies: []
};

// Push it into the friend's comment located at the specific index (in an app the index would be embedded and can be fetched) with the current timestamp and the poster of reply will be the logged in user
let replyCommentIndex = "comments.0.replies";

db.Posts.update({_id: replyTestPostId}, {
    $push: {
        [replyCommentIndex]: replyTestObject
    }
});

//------ SHOW ALL POSTS THAT ARE PUBLIC AND OF FRIENDS (WITH PRIVACY FRIENDS ONLY) -----//

// NOTE: Visibility status 1: Public, 2: Friends Only, 3: Private

db.Users.aggregate([
    {$match: {$or: [{visibilityStatus: NumberInt(1)}, {$and: [{visibilityStatus: NumberInt(2)}, {_id: {$in: loggedInUser.friends}}]}]}},
    {
        $lookup: {
            from: 'Posts',
            localField: '_id',
            foreignField: 'user',
            as: 'friendsPosts'
        }
    },
    {
        $group: {
            _id: "$_id",
            posts: {$push: '$friendsPosts.body'},
        }
    }
]);

//------ SEARCH USER -----//
let searchTerm = "testing.com";
db.Users.find({$or: [{"username": {$regex: ".*" + searchTerm + ".*"}}, {"email": {$regex: ".*" + searchTerm + ".*"}}]});

//------ SEND FRIEND REQUEST -----//
db.Users.update({username: 'user3'}, {
    $push: {
        friendRequests: loggedInUser._id
    }
});

//------ SHOW FRIEND REQUESTS -----//
db.Users.aggregate([
    {$match: {_id: loggedInUser._id}},
    {
        $lookup: {
            from: 'Users',
            localField: 'friendRequests',
            foreignField: '_id',
            as: 'showFriends'
        }
    },
    {
        $group: {
            _id: "$_id",
            friendRequests: {$push: '$showFriends.username'},
        }
    }
]);

//------ ACCEPT FRIEND REQUEST -----//
let acceptRequestId = loggedInUser.friendRequests[0];

db.Users.update({_id: loggedInUser._id}, {
    $push: {
        friends: acceptRequestId
    },
    $pull: {
        friendRequests: acceptRequestId
    }
});

db.Users.update({_id: acceptRequestId}, {
    $push: {
        friends: loggedInUser._id
    }
});


//------ REJECT FRIEND REQUEST -----//
let rejectUser = loggedInUser.friendRequests[0];

db.Users.update({_id: loggedInUser._id}, {
    $pull: {
        friendRequests: rejectUser
    }
});

//------ UN-FRIEND -----//
let friendIndex = 0;
db.Users.update({_id: loggedInUser._id}, {
    $pull: {
        friends: loggedInUser.friends[friendIndex]
    }
});

//------ SHOW FRIEND LIST -----//
db.Users.aggregate([
    {$match: {_id: loggedInUser._id}},
    {
        $lookup: {
            from: 'Users',
            localField: 'friends',
            foreignField: '_id',
            as: 'showFriends'
        }
    },
    {
        $group: {
            _id: "$_id",
            friends: {$push: '$showFriends.username'},
        }
    }
]);