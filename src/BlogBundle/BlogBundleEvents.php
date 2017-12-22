<?php

namespace BlogBundle;

final class BlogBundleEvents
{
    const BLOG_CREATED = 'blog.created';
    const BLOG_EDIT = 'blog.edit';
    const BLOG_DELETE = 'blog.delete';
    const COMMENT_DELETE = 'comment.delete';
    const MESSAGE_DELETE = 'message.delete';
    const MESSAGE_CREATE = 'message.create';
}