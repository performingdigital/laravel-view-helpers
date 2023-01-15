<?php

namespace Performing\View\Helpers;

enum ColumnType: string
{
    case Text = 'text';
    case Tags = 'tags';
    case Link = 'link';
    case User = 'user';
    case Actions = 'actions';
}
