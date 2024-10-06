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
 * @method static \Illuminate\Database\Eloquent\Builder|Customer callable()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer contactable()
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Customer mailable()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereVatNumber($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Device completed()
 * @method static \Database\Factories\DeviceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device ofStatus(\App\Enums\DeviceStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Device ofType(\App\Enums\DeviceType $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Device pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder|Device since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder|Device sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Device sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|Device sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereWarrantyExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device withWarranty()
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
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceLog whereUserId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice overdue()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice unpaid()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
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
 * @property-read \App\Models\Ticket $ticket
 * @method static \Illuminate\Database\Eloquent\Builder|Order billable()
 * @method static \Illuminate\Database\Eloquent\Builder|Order cancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Order completed()
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order free()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order notCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Order ofStatus(\App\Enums\OrderStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Order pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder|Order since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder|Order sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Order sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|Order sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUrl($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Task approved()
 * @method static \Illuminate\Database\Eloquent\Builder|Task billable()
 * @method static \Illuminate\Database\Eloquent\Builder|Task cancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Task completed()
 * @method static \Database\Factories\TaskFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Task free()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task notCancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|Task ofStatus(\App\Enums\TaskStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Task ofType(\App\Enums\TaskType $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Task pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder|Task sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Task sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|Task sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereIsBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket assignable()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket assigned()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket completed()
 * @method static \Database\Factories\TicketFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket ofPriority(\App\Enums\Priority $priority)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket ofStatus(\App\Enums\TicketStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket outstanding()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket overdue()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket prioritized()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereAssigneeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCompletedOrdersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCompletedTasksCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereTotalOrdersCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereTotalTasksCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction claims()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction discounts()
 * @method static \Database\Factories\TransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction ofMethod(\App\Enums\TransactionMethod $method)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction ofType(\App\Enums\TransactionType $type)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction payments()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction refunds()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|User admins()
 * @method static \Illuminate\Database\Eloquent\Builder|User callable()
 * @method static \Illuminate\Database\Eloquent\Builder|User contactable()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User mailable()
 * @method static \Illuminate\Database\Eloquent\Builder|User managers()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User ofRole(\App\Enums\UserRole $role)
 * @method static \Illuminate\Database\Eloquent\Builder|User ofStatus(\App\Enums\UserStatus $status)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User search(?string $keyword)
 * @method static \Illuminate\Database\Eloquent\Builder|User since(\App\Enums\Interval $interval)
 * @method static \Illuminate\Database\Eloquent\Builder|User sinceThisMonth()
 * @method static \Illuminate\Database\Eloquent\Builder|User sinceThisWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|User sinceToday()
 * @method static \Illuminate\Database\Eloquent\Builder|User technicians()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

