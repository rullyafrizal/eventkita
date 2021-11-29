<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Article
 *
 * @property int $id
 * @property string $title
 * @property string|null $thumbnail
 * @property string|null $body
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Article filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Query\Builder|Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Article withoutTrashed()
 */
	class Article extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string|null $description
 * @property int $quota
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property int $user_id
 * @property int $event_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventInformation[] $eventInformations
 * @property-read int|null $event_informations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EventPicture[] $eventPictures
 * @property-read int|null $event_pictures_count
 * @property-read \App\Models\EventType $eventType
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Query\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Event withoutTrashed()
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventInformation
 *
 * @property-read \App\Models\Event $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventInformation newQuery()
 * @method static \Illuminate\Database\Query\Builder|EventInformation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EventInformation query()
 * @method static \Illuminate\Database\Query\Builder|EventInformation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EventInformation withoutTrashed()
 */
	class EventInformation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventPicture
 *
 * @property int $id
 * @property string $path
 * @property int $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Event $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture newQuery()
 * @method static \Illuminate\Database\Query\Builder|EventPicture onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventPicture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EventPicture withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EventPicture withoutTrashed()
 */
	class EventPicture extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EventType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 * @method static \Illuminate\Database\Eloquent\Builder|EventType filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|EventType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventType newQuery()
 * @method static \Illuminate\Database\Query\Builder|EventType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EventType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EventType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EventType withoutTrashed()
 */
	class EventType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Event[] $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

