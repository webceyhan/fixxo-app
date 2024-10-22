<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $company
 * @property string|null $vat_number
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer callable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer contactable()
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer mailable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereVatNumber($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $customer_id
 * @property string $model
 * @property string|null $brand
 * @property string|null $serial_number
 * @property \Illuminate\Support\Carbon|null $purchase_date
 * @property \Illuminate\Support\Carbon|null $warranty_expire_date
 * @property \App\Enums\DeviceType $type
 * @property \App\Enums\DeviceStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DeviceLog> $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $tickets
 * @property-read int|null $tickets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device completed()
 * @method static \Database\Factories\DeviceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device ofStatus(\App\Enums\DeviceStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device ofType(\App\Enums\DeviceType $type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereWarrantyExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device withWarranty()
 */
	class Device extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $device_id
 * @property int $user_id
 * @property string|null $message
 * @property \App\Enums\DeviceStatus $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Device $device
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereUserId($value)
 */
	class DeviceLog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $ticket_id
 * @property float $total
 * @property \Illuminate\Support\Carbon $due_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $balance
 * @property-read mixed $is_paid
 * @property-read mixed $orders_cost
 * @property-read mixed $tasks_cost
 * @property-read \App\Models\Ticket $ticket
 * @property-read mixed $total_paid
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Database\Factories\InvoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice overdue()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice unpaid()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedAt($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $ticket_id
 * @property string $name
 * @property string|null $url
 * @property int $quantity
 * @property float $cost
 * @property bool $is_billable
 * @property \App\Enums\OrderStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property-read \App\Models\Ticket $ticket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order billable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order cancelled()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order completed()
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order free()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order notCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order ofStatus(\App\Enums\OrderStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereIsBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUrl($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $ticket_id
 * @property string $description
 * @property float $cost
 * @property bool $is_billable
 * @property \App\Enums\TaskType $type
 * @property \App\Enums\TaskStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property-read \App\Models\Ticket $ticket
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task billable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task cancelled()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task completed()
 * @method static \Database\Factories\TaskFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task free()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task notCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task ofStatus(\App\Enums\TaskStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task ofType(\App\Enums\TaskType $type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereIsBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 */
	class Task extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $assignee_id
 * @property int $customer_id
 * @property int $device_id
 * @property string $description
 * @property \App\Enums\Priority $priority
 * @property \App\Enums\TicketStatus $status
 * @property \Illuminate\Support\Carbon $due_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $balance
 * @property int $total_tasks_count
 * @property int $completed_tasks_count
 * @property int $total_orders_count
 * @property int $completed_orders_count
 * @property-read \App\Models\User|null $assignee
 * @property-read \App\Models\Customer $customer
 * @property-read mixed $delivery_signature_url
 * @property-read \App\Models\Device $device
 * @property-read mixed $intake_signature_url
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read mixed $qr_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read mixed $uploaded_urls
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket assignable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket assigned()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket completed()
 * @method static \Database\Factories\TicketFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket ofPriority(\App\Enums\Priority $priority)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket ofStatus(\App\Enums\TicketStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket outstanding()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket overdue()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket prioritized()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereAssigneeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereCompletedOrdersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereCompletedTasksCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereTotalOrdersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereTotalTasksCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ticket whereUpdatedAt($value)
 */
	class Ticket extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $invoice_id
 * @property float $amount
 * @property string|null $note
 * @property \App\Enums\TransactionMethod $method
 * @property \App\Enums\TransactionType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Invoice $invoice
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction claims()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction discounts()
 * @method static \Database\Factories\TransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction ofMethod(\App\Enums\TransactionMethod $method)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction ofType(\App\Enums\TransactionType $type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction payments()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction refunds()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $password
 * @property string|null $remember_token
 * @property \App\Enums\UserRole $role
 * @property \App\Enums\UserStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ticket> $assignedTickets
 * @property-read int|null $assigned_tickets_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User callable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User contactable()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User mailable()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User managers()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User ofRole(\App\Enums\UserRole $role)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User ofStatus(\App\Enums\UserStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User technicians()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

